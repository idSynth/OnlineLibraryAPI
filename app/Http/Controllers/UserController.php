<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Users;
use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        $password =$request->input('password');

        $user = Users::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'api_key' => base64_encode(str::random(40))
            ]);
        return response()->json(['user' => $user], 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);
        $user = Users::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(str::random(40));
            Users::where('email', $request->input('login'))->update(['api_key' => "$apikey"]);;
            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }
}
?>
