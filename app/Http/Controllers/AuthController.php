<?php

namespace App\Http\Controllers;


// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreUserRequest;
// use GuzzleHttp\Exception\RequestException;


class AuthController extends Controller
{
    public function registerView(){
        return view('auth.register');
    }

    public function register_user(StoreUserRequest $request){
        // $request->validate($request->rules(),$request->all());
        $theUrl     = config('app.guzzle_test_url').'/api/register';
        
            $response= Http::post($theUrl, [
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'password'=> $request->password
                
            ]);
            // dd($response->json());
            echo $response;
            // return view('your-blade-view', ['apiResponse' => $data]);
            // dd($response->json());
            // return $response;
            // return redirect()->route('welcome');
            // if ($response->successful()) {
            //                 // Registration was successful
            //                 return redirect()->route('welcome')->with('success', 'Registration successful.');
            //             } else {
            //                 // Handle API error response
            //                 return back()->withErrors(['error' => 'API responded with an error.']);
            //             }
            // }
        }


    

    public function register_fake(){
        $theUrl     = config('app.guzzle_test_url').'/api/register';
        $response= Http::post('https://jsonplaceholder.typicode.com/posts', [
            'userId'=> '12',
            'id'=>'102',
            'title'=> "haru",
            'body'=> "cupiditate quo est a modi nesciunt soluta
            ipsa voluptctio eum
            accusamus ratione",
        ]);
         dd($response->successful());

    }
}

            // if ($response->successful()) {
            //                 // Registration was successful
            //                 return redirect()->back()->with('success', 'Registration successful.');
            //             } else {
            //                 // Handle API error response
            //                 return back()->withErrors(['error' => 'API responded with an error.']);
            //             }
            //         } catch (RequestException $e) {
            //         // Handle the timeout
            //         return back()->withErrors(['error' => 'API request timed out. Please try again.']);
            //         }
        // $client = new Client();
        // $response = $client->request('post', 'http://127.0.0.1:8000/api/register', [
        //     'form_params' => [
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'password'=> $request->password,
        //         'password_confirmation' => $request->password_confirmation
        //     ],
        // ]);
        // dd($response->getStatusCode());
        // if ($response->getStatusCode() == 200) {
        //     return redirect()->back()->with('success', 'Registration successful.');
        // }else{
        //     return back()->withErrors(['error' => 'API responded with an error.']);
        // }
        
        // $client = new Client();
        // $data= [
        //     'name'=>$request->name,
        //             'email'=>$request->email,
        //             'password'=> $request->password,
        //              'password_confirmation' => $request->password_confirmation
        // ];
        // $request_data = json_encode($data);
        // // $headers=[  'Accept' => 'application/json',
        // // ];
        // $response = $client->post($theUrl,[
        //     // 'headers' => $headers,
        //     'json' => $request_data,
        // ]);
        

    //         if ($response->successful()) {
    //             // Registration was successful
    //             return redirect()->back()->with('success', 'Registration successful.');
    //         } else {
    //             // Handle API error response
    //             return back()->withErrors(['error' => 'API responded with an error.']);
    //         }
    //     } catch (RequestException $e) {
    //     // Handle the timeout
    //     return back()->withErrors(['error' => 'API request timed out. Please try again.']);
    // }

