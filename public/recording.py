import os
import cv2
import numpy as np
import pyaudio
import wave
import pyautogui
import sys
import time
import sounddevice as sd 
import soundfile as sf
import threading
import subprocess

from moviepy.editor import VideoFileClip, AudioFileClip

def record_system_audio(session_dir):
    try:
        stereo_input_device_index = None
        devices = sd.query_devices()
        
        # Find stereo mix device index
        for index, device in enumerate(devices):
            if 'stereo mix' in device['name'].lower():
                stereo_input_device_index = index
                break
        
        if stereo_input_device_index is None:
            raise ValueError("Stereo mix device not found")

        frames = int(7200 * devices[stereo_input_device_index]['default_samplerate'])
        sample_rate = int(sd.query_devices(stereo_input_device_index)['default_samplerate'])
        
        # Start recording with the selected device
        audio_data = sd.rec(frames, samplerate=sample_rate, channels=2, dtype='float32',
                            device=stereo_input_device_index, blocking=False)
        
        record_start_time = time.time()
        record_end_time = None

        while True:
            if os.path.exists(f"{session_dir}/stop_recording.txt"):
                record_end_time = time.time()
                break
            
        sd.stop()
        record_end_time = time.time()

        recording_duration = record_end_time - record_start_time if record_end_time else 0
        frames_to_keep = int(recording_duration * sample_rate)

        sf.write(f"{session_dir}/system.wav", audio_data[:frames_to_keep], sample_rate)
        print(f"System audio recorded and saved to {session_dir}/system.wav")

    except Exception as e:
        print(f"Error recording system audio: {str(e)}")
        # Log the error or handle it as needed



def record_microphone_audio(session_dir):
    FORMAT = pyaudio.paInt16
    RATE = 44100
    CHUNK = int(RATE / 23)

    audio = pyaudio.PyAudio()
    stream = audio.open(format=FORMAT, channels=2, rate=RATE, input=True, frames_per_buffer=CHUNK)
    out_audio = wave.open(f"{session_dir}/output_audio.wav", "wb")
    out_audio.setnchannels(2)
    out_audio.setsampwidth(audio.get_sample_size(FORMAT))
    out_audio.setframerate(RATE)

    try:
        while not os.path.exists(f"{session_dir}/stop_recording.txt"):
            data_mic = stream.read(CHUNK)
            out_audio.writeframes(data_mic)

    finally:
        stream.stop_stream()
        stream.close()
        out_audio.close()
        audio.terminate()


def start_recording(session_id, session_dir):
    os.makedirs(session_dir, exist_ok=True)
    print("Session directory created:", session_dir)

    system_audio_thread = threading.Thread(target=record_system_audio, args=(session_dir,))
    microphone_audio_thread = threading.Thread(target=record_microphone_audio, args=(session_dir,))
    
    system_audio_thread.start()
    microphone_audio_thread.start()

    SCREEN_SIZE = tuple(pyautogui.size())
    fourcc = cv2.VideoWriter_fourcc(*"XVID")
    fps = 21.0
    out_video = cv2.VideoWriter(f"{session_dir}/output.avi", fourcc, fps, SCREEN_SIZE)
    print("Video recording started.")

    try:
        while not os.path.exists(f"{session_dir}/stop_recording.txt"):
            img = pyautogui.screenshot()
            frame = np.array(img)
            frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
            out_video.write(frame)

    finally:
        out_video.release()
        system_audio_thread.join()
        microphone_audio_thread.join()

    return "Recording completed."

def merge_audio(system_audio_path, microphone_audio_path, output_audio_path):
    print('Merging audio...')
    
    ffmpeg_command = f"ffmpeg -i \"{system_audio_path}\" -i \"{microphone_audio_path}\" -filter_complex amerge -ac 2 \"{output_audio_path}\""
    subprocess.run(ffmpeg_command, shell=True, check=True)

    print(f"Combined audio saved to: {output_audio_path}")
    return 'Done'

def combine_audio_video(video_path, audio_path, output_path):
    try:
        
        video_clip = VideoFileClip(video_path)
        audio_clip = AudioFileClip(audio_path)
      
        # Adjust audio duration to match the duration of the video clip
        audio_duration = min(video_clip.duration, audio_clip.duration)
        audio_clip = audio_clip.subclip(0, audio_duration)
       
        # Set audio for the video clip
        final_clip = video_clip.set_audio(audio_clip)
        
        # Write the final video file with audio
        final_clip.write_videofile(output_path, codec='libx264', audio_codec='aac', verbose=True)
        
        message = f"Combined audio and video saved to: {output_path}"
    except Exception as e:
        message = f"Error occurred during audio-video combination: {str(e)}"

    return message


def stop_recording(session_id, session_dir):
    try:
        stop_file = os.path.join(session_dir, "stop_recording.txt")
        with open(stop_file, "w") as f:
            pass
        message = "Recording stopped."
    except Exception as e:
        message = f"Error occurred while stopping recording: {str(e)}"

    return message

if __name__ == "__main__":
    # Check if the correct number of command-line arguments are provided
    if len(sys.argv) != 3:
        print("Usage: python recording.py <session_id> [start/stop]")
        sys.exit(1)

    # Parse command-line arguments
    session_id = sys.argv[1]
    action = sys.argv[2]
    basic_path = os.path.dirname(os.path.abspath(__file__))
    session_dir = os.path.join(basic_path, "recordings", session_id)

    if action == "start":
        # Start recording asynchronously
        recording_thread = threading.Thread(target=start_recording, args=(session_id, session_dir))
        recording_thread.start()

        # Perform subsequent operations asynchronously once recording is complete
        recording_thread.join()  # Wait for recording to finish

        ful_aud_path = os.path.join(session_dir, "final_audio.wav")
        system_audio = os.path.join(session_dir, "system.wav")
        microphone_path = os.path.join(session_dir, "output_audio.wav")

        # Wait for both audio recordings to finish
        while not (os.path.exists(system_audio) and os.path.exists(microphone_path)):
            time.sleep(1)  # Check every second

        # Merge audio files asynchronously
        merge_audio_thread = threading.Thread(target=merge_audio, args=(system_audio, microphone_path, ful_aud_path))
        merge_audio_thread.start()

        # Wait for audio merging to finish
        merge_audio_thread.join()

        # Combine audio and video files asynchronously
        video_path = os.path.join(session_dir, "output.avi")
        audio_path = os.path.join(session_dir, "final_audio.wav")
        output_path = os.path.join(session_dir, "final_output.mp4")
        print(combine_audio_video(video_path, audio_path, output_path))


    elif action == "stop":
        # Stop recording asynchronously
        stop_recording_thread = threading.Thread(target=stop_recording, args=(session_id, session_dir))
        stop_recording_thread.start()

        # Continue with other tasks or return the response if needed

    else:
        print("Invalid action. Please use 'start' or 'stop'.")
