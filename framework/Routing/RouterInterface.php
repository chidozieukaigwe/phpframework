<?php

namespace ChidoUkaigwe\Framework\Routing;

use ChidoUkaigwe\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request);
}