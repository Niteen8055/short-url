<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortURL;
use App\ShortURL\Classes\Builder;
use App\ShortURL\Classes\Resolver;
use App\Http\Requests\GenerateUrlRequest;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UrlKeyGenerator;
use App\Facades\ShortURLFacade;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ShortURLException;

class ShortURLController extends Controller
{
    protected Builder $builder;
    protected Resolver $resolver;
    protected UrlKeyGenerator $urlKeyGenerator;

    // Modify the constructor to inject UrlKeyGenerator
    public function __construct(Builder $builder, Resolver $resolver, UrlKeyGenerator $urlKeyGenerator)
    {
        $this->builder = $builder;
        $this->resolver = $resolver;
        $this->urlKeyGenerator = $urlKeyGenerator;
    }

    public function show()
    {
        return view('admin.url.short_url_create');
    }

    public function create(GenerateUrlRequest $request)
    {
        try {
            $userId = Auth::id();

            
            // Retrieve destination URL and URL key from the request
            $destinationUrl = $request->input('destination_url');
            $urlKey = $request->input('url_key');

            // Create the short URL based on the presence of the URL key
            if (!$urlKey) {
                $shortUrl = ShortURLFacade::destinationUrl($destinationUrl)
                    ->userId($userId)
                    ->secure(true)
                    ->redirectStatusCode(301)
                    ->make();
            } else {
                $shortUrl = ShortURLFacade::destinationUrl($destinationUrl)
                    ->urlKey($urlKey)
                    ->userId($userId)
                    ->secure(true)
                    ->redirectStatusCode(301)
                    ->make();
            }

            // Prepare the short URL data to return in the response
            $shortUrlData = [
                'url_key' => $shortUrl->url_key,
                'short_url' => $shortUrl->default_short_url,
                'destination_url' => $destinationUrl,
            ];

            // Return success response
            return response()->json([
                'status' => 'Success',
                'message' => 'Short URL created successfully.',
                'data' => $shortUrlData,
            ]);

        } catch (ShortURLException $e) {
            // Handle subscription related exceptions
            Log::error('Subscription Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
            ], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            Log::error('Validation Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Handle other unexpected errors
            Log::error('URL Creation Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'Error',
                'message' => 'An error occurred during URL creation.',
            ], 500);
        }
    }



    public function __invoke(Request $request, string $shortURLKey)
    {
        // Retrieve the short URL entry from the database
        $shortURL = ShortURL::where('url_key', $shortURLKey)->firstOrFail();
        $this->resolver->handleVisit($request, $shortURL);

        // Redirect to the destination URL
        return redirect()->to($shortURL->destination_url);
    }

    public function list()
    {
        $userId = Auth::id();

        // Fetch only the required columns for the short URLs belonging to the authenticated user
        $shortUrlData = ShortURL::select('destination_url', 'url_key', 'default_short_url', 'created_at')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.url.short_url_list', ['shortUrlData' => $shortUrlData]);
    }



}
