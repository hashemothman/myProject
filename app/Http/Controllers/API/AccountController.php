<?php

namespace App\Http\Controllers\API;

use App\Models\Account;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use Endroid\QrCode\Encoding\Encoding;
use App\Http\Resources\AccountResource;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\WalletAndAccountTrait;
use App\Http\Requests\SenderAccountRequest;
use Endroid\QrCode\Response\QrCodeResponse;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class AccountController extends Controller
{
    use WalletAndAccountTrait;
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
        $account = $this->createAccount($request);
        return $this->customeResponse(new AccountResource($account), 'Done', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user()->id;
        $account= Account::where('user_id',$user)->first();
        if ($account) {
            return $this->customeResponse(new AccountResource($account), 'Done', 200);
        }
        return $this->customeResponse($account, 'account not found', 404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request, Account $account)
    {
        if ($account) {
            $account->update([
                'user_id'      => $request->user_id,
                'account'      => $request->account,
                'account_type' => $request->account_type,
                // 'q_rcode'      => $request->q_rcode,
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

    public function getAccount(SenderAccountRequest $request)
    {
        try {
            $sender_account = Account::where('account', $request->account_number)
                ->with(['user' => function ($query) {
                    $query->select('id', 'status')
                        ->with('wallets:id,coin_id,user_id');
                }])
                ->get();

            return $this->customeResponse($sender_account, 'Done', 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->customeResponse(null, 'there is something error in the server', 500);
        }
    }
}
