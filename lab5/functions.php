<?php

class Functions
{

    public static function getAllP(string $html): string
    {
        $reg = '~<p>—[^>]*</p>~iu';
        $result = '';
        preg_match_all($reg, $html, $out);

        foreach ($out [0] as $item) {
            $result .= $item . '\n';
        }

        return $result;
    }

    public static function smartTrim(string $html): string
    {
        $regs = [
            '~[a-zA-Zа-яА-ЯёЁ] *- *[a-zA-Zа-яА-ЯёЁ]~ui',
            '~[a-zA-Zа-яА-ЯёЁ](( *\\. *)$|( *\\. *[^.]))~ui',
            '~[a-zA-Zа-яА-ЯёЁ] *, *~ui',
            '~[a-zA-Zа-яА-ЯёЁ] *: *~ui'
        ];

        $html = preg_replace_callback(
            $regs[0],
            function ($matches) {
                return str_replace(' ', '', $matches[0]);
            },
            $html
        );

        for ($i = 1; $i < 4; $i++){
            $html = preg_replace_callback(
                $regs[$i],
                function ($matches) {
                    $without_spaces = str_replace(' ', '', $matches[0]);
                    return str_replace([',','.',':'], [', ','. ',': '], $without_spaces);
                },
                $html
            );
        }

        return $html;
    }

    public static function getAllA(string $html): string {
        $result = '';
        $reg = '~<a[^<]*href="[^<]*"[^<]*>~ui';
        preg_match_all($reg, $html, $out);

        $j = 0;
        foreach ($out[0] as $item) {
            $j++;
            preg_match('~href=".*"~ui', $item, $matches);
            $result .= 'Ссылка '.$j.' "'.str_replace('"', '', substr($matches[0], 6, strlen($matches[0]) - 7)).'"\n';
        }

        return $result;
    }

    public static function formatClear(string $html): string {
        $to_delete = ['b', 'i', 'u', 'sup', 'sub', 'pre', 'em', 'strong', 'font', 'mark', 'small', 'q'];
        $reg = '~<.*>.*</.*>~ui';

        preg_match_all($reg, $html, $out);

        foreach ($out[0] as $item){
            preg_match('~<[^<]*>~ui', $item, $start);
            preg_match('~/.*>~ui', $item, $end);
            $start_tag = substr($start[0], 1, strlen($start[0]) - 2);
            $start_tag = explode(' ', $start_tag)[0];
            $end_tag = substr($end[0], 1, strlen($end[0]) - 2);

            if ($start_tag != $end_tag){
                continue;
            }

            if (in_array($start_tag, $to_delete)){
                preg_match('~>.*<~ui', $item, $text);
                $text[0] = substr($text[0], 1, strlen($text[0]) - 2);
                $html = str_replace($item, $text[0], $html);
            }

            preg_match('~<'.$start_tag.'[^<]*>~', $item, $param);
            $param[0] = substr($param[0], 1 + strlen($start_tag), strlen($param[0]) - 2 - strlen($start_tag));
            $html = str_replace($param[0], '', $html);
        }

        return $html;
    }
}