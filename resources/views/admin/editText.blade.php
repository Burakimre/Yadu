@extends('layouts/admin/app')

@section('content')

<h1>{{__('global.edit_lang')}} {{$page}}</h1>
<form action="/admin" method="post">
    @csrf
    <input type="hidden" name="lang_file" value="{{$page}}">
    <input type="hidden" name="lang" value="{{$lang}}">
    <div class="inputFields">
    <?php
        $addedString = "";

        function isObjectArray($key, $item){
            $primaryKey = $key;
            foreach($item as $key => $singleItem){
                if (is_array($singleItem)){
                    printTitle($key);
                    global $addedString;
                    $addedString .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                    isObjectArray($key, $singleItem);
                }
                else {
                    printInputFields($key, $singleItem, $primaryKey);
                }
            } 
        }

        function printTitle($key){
            global $addedString;
            echo "<h4><strong>$addedString $key</strong></h4>";
        }

        function printInputFields($key, $item, $primaryKey){
            global $addedString;
            echo "<h4> $addedString $key </h4><textarea type='text' name='$primaryKey;$key' id='EditInput'>".htmlspecialchars_decode($item)."</textarea>";
        }
    ?>

    @foreach ($x as $key => $item)
        @if (!is_array($item))
            <?php global $addedString; $addedString = "";?>
            <h4>{{$key}}</h4>
            <textarea type="text" name="{{$key}}" id="EditInput">{{htmlspecialchars_decode($item)}}</textarea>
        @else
            <?php 
                global $addedString; 
                $addedString = ""; 
                printTitle($key); 
                $addedString = "&nbsp;&nbsp;&nbsp;&nbsp;"; 
                isObjectArray($key, $item); ?>
        @endif

    @endforeach
    </div>
    <input type="submit" value="submit" class="btn btn-primary submit-edit">
</form>

@endsection