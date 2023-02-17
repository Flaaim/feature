# Логин по номеру телефона или email.

## API
```php

 public function login(Request $request)
    {
        try{
            $field = $this->credentials($request);
            $request->merge([$field => $request->input('login')]);

            if(!Auth::attempt($request->only($field, 'password'))){
                return response()->json([
                    'message' => 'Invalid login details'
                ], 401);
            }
            $user = User::where($field, $request[$field])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('login'))){
            $field = 'phone';
        }else{
            $field = 'email';
        }
        return $field;
    }
```
