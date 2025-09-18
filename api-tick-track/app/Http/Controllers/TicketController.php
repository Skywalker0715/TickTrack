<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketStoreRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TicketResource;
use App\Models\TicketReply;
use App\Http\Resources\TicketReplyResource;
use App\Http\Requests\TicketReplyStoreRequest;

class TicketController extends Controller
{

    public function index(Request $request) 
    {
      try {
        $query = Ticket::query();

        $query->orderBy('created_at', 'desc');

        if($request->search) {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        if($request->status) {
            $query->where('status', $request->status);
        }

        if($request->priority) {
            $query->where('priority', $request->priority);
        }

        if(auth()->user()->role == 'user') {
            $query->where('user_id', auth()->user()->id);
        }

        $tickets = $query->get();
        return response()->json([
            'message' => 'Data tiket berhasil diambil',
            'data' => TicketResource::collection($tickets)
        ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tiket gagal diambil',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function store(TicketStoreRequest $request) 
    {
         $data = $request->validated();

         DB::beginTransaction();

         try {
             $ticket = new Ticket;
             $ticket->user_id = auth()->user()->id;
             $ticket->code = 'TIC-' . rand(10000, 99999);
             $ticket->title = $data['title'];
             $ticket->description = $data['description'];
             $ticket->priority = $data['priority'];
             $ticket->save();

             DB::commit();

             return response()->json([
                 'message' => 'Ticket berhasil ditambahkan',
                 'data' => new TicketResource($ticket)
             ], 201);

         } catch (\Throwable $e) {

             DB::rollBack();

             return response()->json([
                 'message' => 'Ticket gagal ditambahkan',
                 'error' => $e->getMessage()
             ], 500);
         }
    }

    public function show($code) 
    {
        try {
            $ticket = Ticket::where('code', $code)->first();

            if (!$ticket) {
                return response()->json([
                    'message' => 'Ticket tidak ditemukan'
                ], 404);
            }

            if(auth()->user()->role == 'user' && auth()->user()->id != $ticket->user_id) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses ke ticket ini'
                ], 403);
            }

            return response()->json([
                'message' => 'Data tiket berhasil diambil',
                'data' => new TicketResource($ticket)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tiket gagal diambil',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
   public function storeReply(TicketReplyStoreRequest $request, $code)
   {
         DB::beginTransaction();

         try {
               $data = $request->validated();

               $ticket = Ticket::where('code', $code)->first();

               if(!$ticket) {
                 return response()->json([
                       'message' => 'Ticket tidak ditemukan'
                   ], 404);
        }

        if(auth()->user()->role == 'user' && auth()->user()->id != $ticket->user_id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses ke ticket ini'
            ], 403);
        }

        $ticketReply = new TicketReply();
        $ticketReply->ticket_id = $ticket->id;
        $ticketReply->user_id = auth()->user()->id; 
        $ticketReply->content = $data['content'];
        $ticketReply->save();

        if(auth()->user()->role == 'admin') {
            $ticket->status = $data['status'];
            if($data['status'] == 'resolved') {
                $ticket->completed_at = now();
            }
            $ticket->save();
        }

        DB::commit();

        return response()->json([
            'message' => 'Reply berhasil ditambahkan',
            'data' => new TicketReplyResource($ticketReply)
        ], 201);
    } catch (\Throwable $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Reply gagal ditambahkan',
            'error' => $e->getMessage()
        ], 500);
    }
}
}