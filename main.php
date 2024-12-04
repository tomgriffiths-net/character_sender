<?php
//Your Variables go here: $GLOBALS['character_sender']['YourVariableName'] = YourVariableValue
class character_sender{
    //public static function command($line):void{
    //    $lines = explode(" ",$line);
    //    self::sendString($lines[0],$lines[1]);
    //}//Run when base command is class name, $line is anything after base command (string). e.g. > [base command] [$line]
    //public static function init():void{}//Run at startup
    public static function sendString(string $string, string $windowTitle, bool $enterAfter = true, $terminate = false){
        $wparams = json::readFile('packages\\character_sender\\wparams.json');
        $smPath = 'packages\\character_sender\\sendchar.exe';

        mklog('general','Sending string to window: "' . $windowTitle . '"');

        $chars = str_split($string);

        if(is_admin::check()){
            $windowTitle = 'Administrator:  ' . $windowTitle;
        }

        $baseCommand = $smPath . ' /windowtitle:"' . $windowTitle . '" /message:';

        if($terminate){
            exec($baseCommand . 'WM_CLOSE');
        }
        else{
            foreach($chars as $char){
                exec($baseCommand . 'WM_CHAR /wparam:' . $wparams[$char]);
                usleep(20000);
            }
    
            if($enterAfter){
                exec($baseCommand . 'WM_CHAR /wparam:13');
            }
        }
    }
}