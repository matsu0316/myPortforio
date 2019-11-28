<?php 
require(__DIR__.'/../config/config.php');
class Calender{
    public $nextDays;
    public $prevDays;
    private $_month;
    public $thismonth;
    private $_calender;
    public function __construct(){
        $this->_calender=new \MyApp\Controller\Calender();
        if(!isset($_GET['t'])){
            $this->thismonth=new DateTime('today');
        }
        else{
            $this->thismonth=new DateTime('first day of '.$_GET['t']);
        }

        $this->nextDays=new DateTime('first day of '.$this->thismonth->format('Y-m').' +1 month');
        $this->prevDays=new DateTime('last day of '.$this->thismonth->format('Y-m').' -1 month');
        $this->_month=new DatePeriod(
            new DateTime('first day of '.$this->thismonth->format('Y-m')),
            new DateInterval('P1D'),
            new DateTime('first day of '.$this->thismonth->format('Y-m').' +1 month')    
        );
    }
    public function createHead(){
        $head='';
        while($this->nextDays->format('w')!=='0'){
            $head.='<td value="'.$this->nextDays->format('j').'">'.$this->nextDays->format('j').'</td>';
            $this->nextDays->add(new DateInterval('P1D'));
        }
        return $head;
    }
    public function createDays(){
        $today=new DateTime('today');
        $days='';
        foreach($this->_month as $day){
            //var_dump($day->format("w"));
            $_SESSION['indexDay']=$day->format('Y-m-d');
            if($day->format('Y-m-d')===$today->format('Y-m-d')){
                $todayClass='today';    
            }else{
                $todayClass='';
            }
            switch($this->_calender->getScheduledState()){
                case '1':
                    $stat=" busy'>×";
                    break;
                case '2':
                    $stat=" normal'>△";
                    break;
                case '3':
                    $stat=" free'>〇";
                    break;
                default:
                    $stat="'>";
                    break;
            }
            if($day->format('w')==='0'){
                $days.="</tr><tr><td class='scheduled' value='".$day->format("j")."'><span class='isScheduled".$stat."</span><span class='indexValue'>".$day->format('Y-m-d')."</span><span class='sunday day ".$todayClass."'>".$day->format("j").'</span></td>' ;   
            }elseif($day->format('w')==='6'){
                $days.="<td class='scheduled' value='".$day->format("j")."'><span class='isScheduled".$stat."</span><span class='indexValue'>".$day->format('Y-m-d')."</span><span class='saturday day ".$todayClass."'>".$day->format("j").'</td>';
            }else{
                $days.="<td class='scheduled' value='".$day->format("j")."'><span class='isScheduled".$stat."</span><span class='indexValue'>".$day->format('Y-m-d')."</span><span class='day ".$todayClass."'>".$day->format("j").'</td>';
            }
        }
        return $days;
    }
    public function createTail(){
        $tail='';
        while($this->prevDays->format('w')!=='6'){
            $tail='<td value="'.$this->prevDays->format('j').'">'.$this->prevDays->format('j').'</td>'.$tail;
            $this->prevDays->sub(new DateInterval('P1D'));
        }
        return $tail;
    }
    public function createCalender(){
        return $this->createTail().$this->createDays().$this->createHead();
    }
    
}
$calender=new Calender();
//function h($s){
//    htmlspecialchars($s,ENT_QUOTES,"UTF-8");
//}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test</title>
    <link rel="stylesheet" href="./css/test.css">
</head>
<body>
    <a href="index.php">ホーム</a>
    <div class="calender">
    <h1>スケジュール</h1>
        <table>
            <thead>
                <tr>
                    <td><a href="?t=<?=$calender->prevDays->format('Y-m');?>">前月</a></td>
                    <td colspan="5"><a href='./test.php'><?=$calender->thismonth->format('Y-m');?></a></td>
                    <td><a href="?t=<?=$calender->nextDays->format('Y-m');?>">次月</a></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="sunday week">日</td>
                    <td class="week">月</td>
                    <td class="week">火</td>
                    <td class="week">水</td>
                    <td class="week">木</td>
                    <td class="week">金</td>
                    <td class="saturday week">土</td>
                </tr>
                <tr>
                    <?=$calender->createCalender();?>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        $(function(){
            $('td').on('click',function(){
                let indexDay=this;
                $.post('_calender.php',{
                    day:$(this).children('.indexValue').text()
                },function(res){
                    console.log(indexDay);
                    if(res==='1'){
                        $(indexDay).children('.isScheduled').addClass('busy');
                        $(indexDay).children('.isScheduled').text('×');    
                    }else if(res==='2'){
                        $(indexDay).children('.isScheduled').addClass('normal');
                        $(indexDay).children('.isScheduled').removeClass('busy');
                        $(indexDay).children('.isScheduled').text('△');    
                    }else if(res==='3'){
                        $(indexDay).children('.isScheduled').addClass('free');
                        $(indexDay).children('.isScheduled').removeClass('normal');
                        $(indexDay).children('.isScheduled').text('〇');    
                    }else{
                        $(indexDay).children('.isScheduled').removeClass('free');
                        $(indexDay).children('.isScheduled').text('');
                    }
                });
            });
        });
    </script>
</body>
</html>