<?
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerificationController extends Controller
{
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Verifikasi email baru telah dikirim!');
    }
}
