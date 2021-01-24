<?php

namespace App\Http\Controllers;

use App\Models\BotExperience;
use App\Models\BotItem;
use App\Models\BotLog;
use App\Models\BotRuntime;
use App\Models\BotUser;
use App\Models\Item;
use App\Models\ItemStatus;
use App\Models\Skill;
use App\Script;
use Illuminate\Http\Request;

class ScriptController extends Controller
{

    public function submitLog(Request $request)
    {

        $botlog = new BotLog();
        $botlog->scriptID = $request->scriptID;
        $botlog->botUserID = $request->botUserID;
        $botlog->version = $request->version;
        $botlog->mirror = $request->mirror;
        $botlog->log = $request->log;

        $botlog->save();

        return response(['message' => "Log saved for {$request->user}"]);

    }

    public function submitRuntime(Request $request)
    {

        $botRuntime = new BotRuntime();
        $botRuntime->scriptID = $request->scriptID;
        $botRuntime->botUserID = $request->botUserID;
        $botRuntime->version = $request->version;
        $botRuntime->duration = $request->duration;

        $botRuntime->save();

        return response(['message' => "Runtime saved for {$request->user}"]);
    }

    public function submitExperience(Request $request)
    {

        if(empty($request->exp)){
            return response(['message' => "No experience data provided."]);
        }

        $expData = json_decode($request->exp, true);
        foreach($expData as $skillName => $expGained){
            $skill = Skill::where('skillName', '=', $skillName)->first();

            if (empty($skill)) {
                continue;
            }

            $botExperience = new BotExperience();
            $botExperience->scriptID = $request->scriptID;
            $botExperience->botUserID = $request->botUserID;;
            $botExperience->skillID = $skill['id'];
            $botExperience->exp = $expGained;

            $botExperience->save();
        }


        return response(['message' => "Experience saved for {$request->user}"]);

    }

    public function submitItems(Request $request)
    {
        if (empty($request->items)) {
            return response(['message' => 'No item data provided']);
        }

        $itemData = json_decode($request->items, true);

        foreach($itemData as $i){
            $item = Item::firstOrCreate(['itemName' => $i['name']]);

            $itemStatus = ItemStatus::where('status', '=', $i['status'])->first();

            if (empty($itemStatus)) {
                return response(['message' => 'Invalid item status.']);
            }

            $botItem = new BotItem();
            $botItem->scriptID = $request->scriptID;
            $botItem->botUserID = $request->botUserID;
            $botItem->itemID = $item['id'];
            $botItem->amount = $i['amount'];
            $botItem->itemStatusID = $itemStatus['id'];

            $botItem->save();
        }

        return response(['message' => "Item data saved for {$request->user}"]);

    }
}
