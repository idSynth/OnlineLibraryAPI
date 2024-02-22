<?php
namespace App\Http\Controllers;
use App\Models\Books;
use App\Models\User_Favorites;
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
     * @throws \Exception
     */
    public function addFavorite(Request $request, $id)
    {
        $book = $this->validateBook($id);

        if(User_Favorites::where('book_id', $id)->first())
            return response()->json('Book already added to favorites',409);

        $apiKey = $request->header('x-api-key');
        $user = Users::where('api_key', $apiKey)->first();

        User_Favorites::create(['book_id' => $id, 'user_id' => $user->id]);

        return response()->json($book);
    }

    public function getFavorite(Request $request)
    {
        $apiKey = $request->header('x-api-key');
        $user = Users::where('api_key', $apiKey)->first();

        $favorites = User_Favorites::where('user_id', $user->id)->get();

        return response()->json(['Favorites' => $favorites], 201);
    }

    /**
     * @throws \Exception
     */
    public function removeFavorite(Request $request, $id)
    {
        $this->validateBook($id);

        $apiKey = $request->header('x-api-key');
        $user = Users::where('api_key', $apiKey)->first();

        $favorites = User_Favorites::where('book_id', $id)->where('user_id', $user->id);

        if(!$favorites->exists())
            return response()->json(['Book not found'],404);

        $favorites->delete();

        return response()->json(['Book removed from favorites'],201);
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
        $password = $request->input('password');

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
            $user->update(['api_key' => "$apikey"]);
            return response()->json(['status' => 'success','api_key' => $user->api_key]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }
}
?>
