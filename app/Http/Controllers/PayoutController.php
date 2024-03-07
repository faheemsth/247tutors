<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Facades\Paypal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Wallet;
use App\Models\User;
use App\Models\PendingPayment;
use PHPMailer\PHPMailer\PHPMailer;
use Stripe\Stripe;
use Stripe\Payout;
use Stripe\Transfer;
use Stripe\Balance;


class PayoutController extends Controller
{

    public function check()
    {
        return PayoutAmount('10','acct_1OoKzjSDq7qRUMRw');
    }

    public function payout()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $user = User::where('id', \Auth::user()->id)->first();

        $wallet = Wallet::where('user_id', \Auth::user()->id)->first();

        if ($user) {
            if ($user->paypal_email != null) {
                if ($wallet) {
                    if ($wallet->net_income > 0) {

                        $data = [
                            'student' => $user->first_name . ' ' . $user->last_name,
                            'tutor' => $user->first_name . ' ' . $user->last_name,
                        ];

                        $imagePath = public_path('assets/images/247 NEW Logo 1.png');
                        $view = view('pages.mails.WithDrawWalletAmount', $data)->render();
                        $mail = new PHPMailer(true);
                        $mail->CharSet = 'UTF-8';
                        $mail->setFrom('support@247tutors.com', '247 Tutors');
                        $mail->isHTML(true);
                        $mail->Subject = "Withdrawal of Funds from 247Tutors Platform";
                        $mail->Body = $view;
                        $mail->AddEmbeddedImage($imagePath, 'logo');
                        $mail->AltBody = '';
                        $mail->addAddress($user->email, $user->first_name . ' ' . $user->last_name);
                        $mail->isHTML(true);
                        $mail->msgHTML($view);
                        $mail->send();



                        $payoutData = [
                            'sender_batch_header' => [
                                'sender_batch_id' => uniqid(),
                                'email_subject'   => 'You have a Payout!',
                            ],
                            'items' => [
                                [
                                    'recipient_type' => 'EMAIL',
                                    'amount'         => [
                                        'value'    => $wallet->net_income,
                                        'currency' => 'USD',
                                    ],
                                    'note'           => 'Thank you.',
                                    'sender_item_id' => uniqid(),
                                    'receiver'       => $user->paypal_email,
                                ],
                                // Add more items as needed
                            ],
                        ];

                        try {
                            $res = $provider->createBatchPayout($payoutData);

                            if (isset($res['batch_header'])) {
                                $wallet->withdrawn += $wallet->net_income;
                                $wallet->net_income = 0;
                                $wallet->save();
                            }
                            $response['message'] = " Withdraw successfull! ";
                            $response['success'] = true;
                            $response['data'] = $res;
                            $response['status_code'] = 200;
                            return response()->json($response);
                        } catch (\Exception $e) {
                            $response['message'] = " Something went wrong try again later ";
                            $response['success'] = false;
                            $response['data'] = $res;
                            $response['status_code'] = 500;
                            return response()->json($response);
                            dd($e->getMessage());
                        }
                    }
                } else {
                    $response['message'] = " We cannot process this request! ";
                    $response['success'] = true;
                    $response['status_code'] = 501;
                    return response()->json($response);
                }
            } else {
                $response['message'] = " Paypal not configured! ";
                $response['success'] = true;
                $response['status_code'] = 401;
                return response()->json($response);
            }
        }
    }



    public function SevenDayPaymentSendToTutorReminder()
    {

        $PendingPayments = PendingPayment::where('amount', '!=', 0)->where('status', 'Pending')->get();
        foreach ($PendingPayments as $PendingPayment) {
            $wallet = Wallet::where('user_id', $PendingPayment->tutor_id)->first();
            $updatedTime = strtotime($PendingPayment->updated_at);
            $currentTime = time();
            // $twentyFourHoursAgo = $currentTime - (7 * 24 * 3600);

            $twentyFourHoursAgo = $currentTime - (1 * 60);
            if ($updatedTime <= $twentyFourHoursAgo) {
                $user = User::find($wallet->user_id);
                $data = [
                    'student' => $user->first_name . ' ' . $user->last_name,
                ];
                $imagePath = public_path('assets/images/247 NEW Logo 1.png');
                $view = view('pages.mails.WalletPeddingAmountTransferToWallet', $data)->render();
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                $mail->setFrom('support@247tutors.com', '247 Tutors');
                $mail->isHTML(true);
                $mail->Subject = "Withdrawal Available for Your Booking Amount";
                $mail->Body = $view;
                $mail->AddEmbeddedImage($imagePath, 'logo');
                $mail->AltBody = '';
                $mail->addAddress($user->email, $user->first_name . ' ' . $user->last_name);
                $mail->isHTML(true);
                $mail->msgHTML($view);
                $mail->send();

                $wallet->net_income += $PendingPayment->amount;
                $PendingPayment->amount -= $PendingPayment->amount;
                $PendingPayment->status = 'Paid';
                $wallet->save();
                $PendingPayment->save();
            }
        }
    }
}
