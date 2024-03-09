<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Media;
use Illuminate\Support\Str;
  
class CropImageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('cromImage');
    }
        
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
                'image1_base64' => 'required',
                'image2_base64' => 'required',
            ]);

        $input1['name'] = $this->storeBase64($request->image1_base64);
        Media::create($input1);

        $input2['name'] = $this->storeBase64($request->image2_base64);
        Media::create($input2);

        // dd($input1,$input2);

        return back()->with('success', 'Image uploaded successfully.');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    // private function storeBase64($imageBase64)
    // {
    //     list($type, $imageBase64) = explode(';', $imageBase64);
    //     list(, $imageBase64)      = explode(',', $imageBase64);
    //     $imageBase64 = base64_decode($imageBase64);
    //     $imageName= time().'.png';
    //     $path = public_path() . "/uploads/" . $imageName;
  
    //     file_put_contents($path, $imageBase64);
          
    //     return $imageName;
    // }
    private function storeBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64) = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        // $imageName = time() . '.png';
        $imageName = time() . '_' . Str::random(3) . '.png';
        $path = public_path("/uploads/") . $imageName;  
        file_put_contents($path, $imageBase64);
        return $imageName;
    }
}