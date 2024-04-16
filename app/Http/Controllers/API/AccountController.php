<?php

namespace App\Http\Controllers\API;

use App\Models\Account;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Response\QrCodeResponse;
use App\Http\Resources\AccountResource;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();
        return $this->customeResponse(AccountResource::collection($accounts), 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        // $validatedData = $request->validated();
        // // // Generate QR code
        // // $qrCodePath = $this->generateQRCode($validatedData['account']);
        // // // Store account including QR code path
        // // $account = Account::create(array_merge($validatedData, ['q_rcode' => $qrCodePath]));
        // return $this->customeResponse(new AccountResource($account), 'New Account Created Successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        if ($account) {
            return $this->customeResponse(new AccountResource($account), 'Done', 200);
        }
        return $this->customeResponse(null, 'account not found', 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request, Account $account)
    {
        if ($account) {
            $category->update([
                'user_id'      => $request->user_id,
                'account'      => $request->account,
                'account_type' => $request->account_type,
                'q_rcode'      => $request->q_rcode,
            ]);
            return $this->customeResponse(new AccountResource($account), 'The Account updated Successfuly', 200);
        }
        return $this->customeResponse(null, 'account not found', 404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        if ($account) {
            $account->delete();
            return $this->customeResponse("", 'Account deleted successfully', 200);
        }
        return $this->customeResponse(null, 'Account not found', 404);
    }


}
