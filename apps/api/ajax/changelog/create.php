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

    $product = \changelog\Product::withName(HTML::inputInline("product_name"));
    if ($product){
        $title = strtolower(HTML::inputInline("title"));
        $content = strtolower(HTML::inputInline("content"));

        $changelog = new \changelog\Changelog();
        $changelog->user(Client::$viewer);
        $changelog->system(Client::$system);
        $changelog->title=$title;
        $changelog->content=$content;
        $changelog->product_id=$product->id;

        if (!$changelog->save()){
            SQL::markError();
            Ajax::release(Code::DB_ERROR);
        }

        // Set writer
//    $writers=(Word::split(array(" ",",",";","\n"), HTML::inputRaw("writers")));
//    $writers=ARR::unique($writers);
//
//    foreach ($writers as $u){
//        if (Word::prefix($u,"@")){
//            $u=substr($u,1);
//        }
//
//        $u=safe($u);
//        $user=User::withUsername($u);
//
//        if ($user && $user->good()){
//            if (!$product->addWriter($user)){
//                Ajax::release(Code::DB_ERROR);
//            }
//        }
//    }

        $version = strtolower(HTML::inputInline("version"));
        $product->current_version=$version;

        if (!$product->save()){
            SQL::markError();
            Ajax::release(Code::DB_ERROR);
        }

        Ajax::release(Code::success());
    } else {
        Ajax::release("Product name not exist!");
    }
?>