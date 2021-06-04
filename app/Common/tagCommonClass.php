<?php 

namespace app\Common;

class tagCommonClass
{
    public static function tagcheck($tag)
    {
        //全角半角の調整、大文字を小文字に変換
        $tag = strtolower(mb_convert_kana($tag, "KVas"));
        //$tagをexplodeにかけて文字列を配列にわける（区切り文字はスペースで）
        $tags = explode(' ',$tag);
        //配列に重複したものがあれば削除
        return array_unique($tags);
    }
}