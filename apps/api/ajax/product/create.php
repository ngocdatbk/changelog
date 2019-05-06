<?php 
//    \Debugger::showErrors(true);
//    \SQL::showQuery(true);

	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	/**
	 * @desc Create a new business unit
	 */

	SQL::commit();

	$name=HTML::inputInline("name");
	$current_version=strtolower(HTML::inputInline("current_version"));
	
	$product=new \changelog\Product();
	$product->user(Client::$viewer);
	$product->system(Client::$system);
    $product->name=$name;
    $product->current_version=$current_version;

    if (!$product->save()){
        SQL::markError();
        Ajax::release(Code::DB_ERROR);
    }

    // Set people to the business units
    $writers=(Word::split(array(" ",",",";","\n"), HTML::inputRaw("writers")));
    $writers=ARR::unique($writers);

    foreach ($writers as $u){
        if (Word::prefix($u,"@")){
            $u=substr($u,1);
        }

        $u=safe($u);
        $user=User::withUsername($u);

        if ($user && $user->good()){
            if (!$product->addWriter($user)){
                Ajax::release(Code::DB_ERROR);
            }
        }
    }

	Ajax::release(Code::success());
?>