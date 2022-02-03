<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'in:Working,Companion,Herding,Hound,Hybrid,Sporting,Terrier', 'string'],
            'description' => ['required', 'string'],
            'available_at' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            'files' => ['required', 'array'],
            'files.*' => ['required', 'mimes:jpg,jpeg,png,bmp', 'max:10000'],
        ], [
            'files.*.required' => 'Please upload at least one (1) image.',
            'files.*.mimes' => 'Only jpeg, png and bmp images are allowed.',
            'files.*.max' => 'Maximum allowed size for an image is 10MB.',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->getMessages();

            $html = "<ul style='padding-left: 0'>";
            foreach ($messages as $field) {
                $html .= "<li style='list-style-type: none;'>" . implode('</li><li>', array_values($field)) . '</li>';
            }

            $html .= '</ul>';

            return response()->json([
                'success' => false,
                'message' => '<b class="d-block mb-2">Please fix input warnings:</b>' . $html,
            ]);
        } else {
            DB::beginTransaction();

            $addedFiles = [];

            try {
                $product = Product::create([
                    'name' => $data['name'],
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'available_at' => $data['available_at'],
                    'created_by' => Auth::user()->username,
                ]);

                if ($request->hasFile('files')) {
                    $files = $request->file('files');

                    if (count($files) > 0) {
                        $storage = Storage::disk('product_images')->getAdapter()->getPathPrefix();
                        $productImagePath = $storage . DIRECTORY_SEPARATOR . $product->id;
                        File::isDirectory($productImagePath) or File::makeDirectory($productImagePath, 0777, true, true);

                        foreach ($files as $file) {
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $imageName = Str::random(20) . time() . "." . $extension;

                            $file->move($productImagePath, $imageName);

                            ProductImage::create([
                                'product_id' => $product->id,
                                'filename' => $imageName,
                                'original_filename' => $filename,
                                'mime_type' => $file->getClientMimeType(),
                                'created_by' => Auth::user()->username,
                            ]);

                            $addedFiles[] = $productImagePath . DIRECTORY_SEPARATOR . $imageName;
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Product has been created successfully.',
                ]);

            } catch (\Exception $e) {
                DB::rollback();

                \Log::warning($e->getMessage());
                \Log::warning($e->getTraceAsString());

                foreach ($addedFiles as $addedFile) {
                    if (File::exists($addedFile)) {
                        File::delete($addedFile);
                    }
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.',
                ]);
            }
        }
    }

    public function edit($id)
    {
        return view('product.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'category' => ['required', 'in:Working,Companion,Herding,Hound,Hybrid,Sporting,Terrier', 'string'],
                'description' => ['required', 'string'],
                'available_at' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
                'files' => ['sometimes', 'nullable', 'array'],
                'files.*' => ['sometimes', 'nullable', 'mimes:jpg,jpeg,png,bmp', 'max:10000'],
            ], [
                'files.*.required' => 'Please upload at least one (1) image.',
                'files.*.mimes' => 'Only jpeg, png and bmp images are allowed.',
                'files.*.max' => 'Maximum allowed size for an image is 10MB.',
            ]);

            if ($validator->fails()) {
                $messages = $validator->errors()->getMessages();

                $html = "<ul style='padding-left: 0'>";
                foreach ($messages as $field) {
                    $html .= "<li style='list-style-type: none;'>" . implode('</li><li>', array_values($field)) . '</li>';
                }

                $html .= '</ul>';

                return response()->json([
                    'success' => false,
                    'message' => '<b class="d-block mb-2">Please fix input warnings:</b>' . $html,
                ]);
            } else {
                DB::beginTransaction();

                $addedFiles = [];

                try {
                    $product->update([
                        'name' => $data['name'],
                        'category' => $data['category'],
                        'description' => $data['description'],
                        'available_at' => $data['available_at'],
                    ]);

                    if ($request->hasFile('files')) {
                        $files = $request->file('files');

                        if (count($files) > 0) {
                            $storage = Storage::disk('product_images')->getAdapter()->getPathPrefix();
                            $productImagePath = $storage . DIRECTORY_SEPARATOR . $product->id;
                            File::isDirectory($productImagePath) or File::makeDirectory($productImagePath, 0777, true, true);

                            foreach ($files as $file) {
                                $filename = $file->getClientOriginalName();
                                $extension = $file->getClientOriginalExtension();
                                $imageName = Str::random(20) . time() . "." . $extension;

                                $file->move($productImagePath, $imageName);

                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'filename' => $imageName,
                                    'original_filename' => $filename,
                                    'mime_type' => $file->getClientMimeType(),
                                    'created_by' => Auth::user()->username,
                                ]);

                                $addedFiles[] = $productImagePath . DIRECTORY_SEPARATOR . $imageName;
                            }
                        }
                    }

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Product has been updated successfully.',
                    ]);

                } catch (\Exception $e) {
                    DB::rollback();

                    \Log::warning($e->getMessage());
                    \Log::warning($e->getTraceAsString());

                    foreach ($addedFiles as $addedFile) {
                        if (File::exists($addedFile)) {
                            File::delete($addedFile);
                        }
                    }

                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong. Please try again later.',
                    ]);
                }
            }
        } else {
            abort(404);
        }
    }
}
