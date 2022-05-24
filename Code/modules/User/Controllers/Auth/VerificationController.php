<?php


	namespace Modules\User\Controllers\Auth;


	use Illuminate\Auth\Access\AuthorizationException;
	use Illuminate\Auth\Events\Verified;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;

	class VerificationController extends \App\Http\Controllers\Auth\VerificationController
	{

		protected $redirectTo = 'user/profile';

//		public function verify(Request $request)
//		{
//			if ($request->route('id') != $request->user()->getKey()) {
//				throw new AuthorizationException;
//			}
//
//			if ($request->user()->hasVerifiedEmail()) {
//				return redirect($this->redirectPath());
//			}
//
//			if ($request->user()->markEmailAsVerified()) {
//				event(new Verified($request->user()));
//			}
//
//			return redirect($this->redirectPath())->with('verified', true);
//		}
        public function verify(Request $request)
        {
            if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
                throw new AuthorizationException;
            }

            if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
                throw new AuthorizationException;
            }

            if ($request->user()->hasVerifiedEmail()) {
                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect($this->redirectPath());
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            if ($response = $this->verified($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath())->with('verified', true);
        }



        public function redirectPath(){
		    return route('user.admin.detail', ['id' => auth()->id()]);
        }

	}
