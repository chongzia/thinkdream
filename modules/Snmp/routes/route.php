<?php

use Illuminate\Support\Facades\Route;
use Modules\Snmp\Http\Controllers\SnmpUsersController;

Route::prefix('snmp')->group(function(){
    
	Route::adminResource('snmp/users', SnmpUsersController::class);
	//next
});
