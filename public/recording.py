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
    stereo_input_device_index = None
    devices = sd.query_devices()
    for index, device in enumerate(devices):
        if 'stereo mix' in device['name'].lower():
            stereo_input_device_index = index
            break

    frames = int(7200 * devices[stereo_input_device_index]['default_samplerate'])
    sample_rate = int(sd.query_devices(stereo_input_device_index)['default_samplerate'])
    audio_data = sd.rec(frames, samplerate=sample_rate, channels=2, dtype='float32',
                        device=stereo_input_device_index, blocking=False)

    record_start_time = time.time()
    record_end_time = None

    while True:
        if os.path.exists(f"{session_dir}/stop_recording.txt"):
            record_end_time = time.time()
            break
        sd.sleep(100)
        
    sd.stop()
    record_end_time = time.time()

    recording_duration = record_end_time - record_start_time if record_end_time else 0
    frames_to_keep = int(recording_duration * sample_rate)

    sf.write(f"{session_dir}/system.wav", audio_data[:frames_to_keep], sample_rate)
    print(f"System audio recorded and saved to {session_dir}/system.wav")

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
        while True:
            if os.path.exists(f"{session_dir}/stop_recording.txt"):
                break
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
    system_audio_thread.start()

    microphone_audio_thread = threading.Thread(target=record_microphone_audio, args=(session_dir,))
    microphone_audio_thread.start()

    SCREEN_SIZE = tuple(pyautogui.size())
    fourcc = cv2.VideoWriter_fourcc(*"XVID")
    fps = 23.0
    out_video = cv2.VideoWriter(f"{session_dir}/output.avi", fourcc, fps, SCREEN_SIZE)
    print("Video recording started.")

    try:
        while True:
            if os.path.exists(f"{session_dir}/stop_recording.txt"):
                break
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
        audio_clip = audio_clip.set_duration(video_clip.duration)
        final_clip = video_clip.set_audio(audio_clip)
        final_clip.write_videofile(output_path, codec='libx264', audio_codec='aac')
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
    if len(sys.argv) != 3:
        print("Usage: python recording.py <session_id> [start/stop]")
        sys.exit(1)

    session_id = sys.argv[1]
    action = sys.argv[2]
    basic_path = os.path.dirname(os.path.abspath(__file__))
    session_dir = os.path.join(basic_path, "recordings", session_id)

    if action == "start":
        message = start_recording(session_id, session_dir)
        from time import sleep  # Import the sleep function from the time module
        sleep(5)
        ful_aud_path = os.path.join(session_dir, "final_audio.wav")
        system_audio = os.path.join(session_dir, "system.wav")
        microphone_path = os.path.join(session_dir, "output_audio.wav")
        print(merge_audio(system_audio, microphone_path, ful_aud_path))
      
        sleep(5)
        video_path = os.path.join(session_dir, "output.avi")
        audio_path = os.path.join(session_dir, "final_audio.wav")
        output_path = os.path.join(session_dir, "final_output.mp4")
        print(combine_audio_video(video_path, audio_path, output_path))


        ###############Removing extra files##############
        #os.remove(system_audio)
        #os.remove(microphone_path)
        #os.remove(audio_path)

    elif action == "stop":
        message = stop_recording(session_id, session_dir)
        print(message)
    else:
        print("Invalid action. Please use 'start' or 'stop'.")
