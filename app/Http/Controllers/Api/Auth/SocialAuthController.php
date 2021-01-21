<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


use App\User;


class SocialAuthController extends Controller
{
    private function login($user)
    {   
        // return "user".$user;
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'token' => $tokenResult->accessToken,
            // 'refresh_token' => $tokenResult->refreshToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
            'user' => $user
        ]);
    }

    function loginSocial(Request $request)
    {
        $provider = $request->provider;
        if($provider == "APPLE"){
            
            $email = $request->response['email'];
            if ($email){
                ///retorna a pedir email si email es de apple
                $dominio_mail = explode('@', $email);
                if($dominio_mail[1] == "privaterelay.appleid.com"){
                    return response()->json(['dataReturn' => $request->all()], 200);
                }
                ////
                $user_excist = User::where('email', $request->response['email'])->first();
                ///si existe logeamos y devolvemos token
                if($user_excist){
                    $user_excist->user_apple = $request->response['user'];
                    $user_excist->save();
    
                    return $this->login($user_excist);
                }else{
                /// si no existe creamos usuario
                    $user = new User([
                        'name'     => $request->response['givenName'],
                        'lastname' => $request->response['familyName'],
                        'email'    => $request->response['email'],
                        'password' => bcrypt(Str::random(8)),
                        'social_id' => $request->response['user'],
                    ]);
                    $user->save();
    
                    if($user){
                        return $this->login($user);
                    };
                    
                }

            }else{
                $user = User::where('user_apple', $request->response['user'])->first();
                    
                if($user){
                    return $this->login($user);
                };
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        ////////////

        if($provider == "GOOGLE"){
            $social_token = $request->idToken;
            $social_client = new Client();
            $url_social_validation = 'https://oauth2.googleapis.com/tokeninfo?id_token='.$social_token;
        
            $res = $social_client->request('GET',$url_social_validation);
            $response = json_decode($res->getBody(), true);

            $user_excist = User::where('email', $response['email'])->first();
            ///si existe logeamos y devolvemos token
            if($user_excist){
                $user_excist->social_id = $response['sub'];
                $user_excist->save();

                return $this->login($user_excist);
            }else{
            /// si no existe creamos usuario
                $user = new User([
                    'name'     => $response['given_name'],
                    'lastname' => $response['family_name'],
                    'email'    => $response['email'],
                    'password' => bcrypt(Str::random(8)),
                    'social_id' => $response['sub'],
                ]);
                $user->save();

                if($user){
                    return $this->login($user);
                };
                
            }
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        ////////////


        if($provider == "FACEBOOK"){
            $social_token = $request->authToken;
            $social_client = new Client();
            $social_id = $request->id;
            $url_social_validation = 'https://graph.facebook.com/'.$social_id.'?fields=email,first_name,last_name,name&access_token='.$social_token;
        
            $res = $social_client->request('GET',$url_social_validation);
            $response = json_decode($res->getBody(), true);
            
            $user_excist = User::where('email', $response['email'])->first();
            ///si existe logeamos y devolvemos token
            if($user_excist){
                $user_excist->social_id = $response['id'];
                $user_excist->save();

                return $this->login($user_excist);
            }else{
            /// si no existe creamos usuario
                $user = new User([
                    'name'     => $response['first_name'],
                    'lastname' => $response['last_name'],
                    'email'    => $response['email'],
                    'password' => bcrypt(Str::random(8)),
                    'social_id' => $response['id'],
                ]);
                $user->save();

                if($user){
                    return $this->login($user);
                };
            }
        return response()->json(['message' => 'Unauthorized'], 401);

        }
    }
}
