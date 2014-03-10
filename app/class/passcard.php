<?php
	/**
     * 密保卡类
     * @anthor Chen Wei Han <csq-3@163.com>
     * @copyright Chen Wei Han 2011-10-25
     * @link http://csq-3.blog.163.com
     */
     
    class Passcard {

		   public function __construct() {
			     $this->card_num_length = 10; //随机10个数字+时间=卡号
				 $this->str_length_col = 10;  //随机10个字母 列数
				 $this->str_length_row = 8;   //行数
				 $this->num_length = 3;       //随机3个数字 单元数值
				 $this->savepath="image/";    //保存图片地址
				 $this->fontpath="tool/";     //字体引入地址
           }
           
		   //获取生成图片数据
		   public function get_img_data() {
			     $data = array();
				 $this->rand_str   = $this->get_rand_str();
				 $data['code']     = $this->get_matrix();
				 $data['letter']   = $this->rand_str;       
				 $data['card_num'] = $this->rand_num(10).time();
				 $data['add_time'] = time();
				 echo  $data['letter']."<br>";
				 return $data;
		   }

		   //获取序列化矩阵数据
           private function get_matrix() {
                 return serialize($this->rand_matrix());			
           }
		   
		   //生成随机列项
		   private function get_rand_str() {
			     return $this->rand_str($this->str_length_col); 
		   }
				   

		   //生成对应矩阵数据eg:[L1]='365'
           private function rand_matrix() {			 
			  $rand_str = $this->rand_str;
			  
			  for($k=0; $k<$this->str_length_col; $k++) 
			  {     
				 for ($i = 0; $i < $this->str_length_row;$i++)     
				 {                    
					$rand = $this->rand_num($this->num_length);
					$arr[$rand_str{$k} . ($i+1)] =  $rand;     
				 } 
			  }

			  return $arr;
           }

           //没有尽一步封装
		   public function create_passcard_img($info) {
                $codes = unserialize($info['code']);
				//初始化图像
				$height = 332;          
				$width =  626;       
				$im    = imagecreatetruecolor($width,$height);               //新建一个真彩色图像    
				$linecolor = imagecolorallocate($im, 229,229,229);           //图像分配背景RGB颜色   
				$fontcolor = imagecolorallocate($im, 0, 0, 0);               //字体分配背景RGB颜色   
				$top_rectangle_color  = imagecolorallocate($im,241,254,237); //顶部首行分配背景RGB颜色
				$top_letter_color     = imagecolorallocate($im,54,126,76);   //顶部首行字母分配背景RGB颜色
				$left_rectangle_color = imagecolorallocate($im,243,247,255); //左边首列分配背景RGB颜色
				$left_num_color       = imagecolorallocate($im,4,68,192);    //左边首列数字分配背景RGB颜色
				$logo_str_color       = imagecolorallocate($im,0,0,0);       //logo区域分配背景RGB颜色
				imagefill($im,0,0,imagecolorallocate($im,255,255,255));	     //填充色


                //标题栏目
				$font    =  $this->fontpath.'simsun.ttc';  
				$font_en =  $this->fontpath.'CONSOLA.TTF';
				$font2   =  $this->fontpath.'simhei.ttf';		
				$dst = imagecreatefromjpeg($this->fontpath."logo.jpg");            //从给定的文件名取得的图像   
				imagecopymerge($im,$dst,120,15,0,0,193,55,100);   //拷贝并合并图像的一部分  
				imageline($im,10,72,$width-10,72,$linecolor);     //画一条线段       
				$ltext = "电子密保卡";          
				imagettftext($im,10,0,340,47,$logo_str_color,$font2,$ltext); //用 TrueType 字体向图像写入文本				
				//写入卡号          
				$cardnum = $info['card_num'];          
				for($i=0;$i<5;$i++)
				{              
					  $p.= substr($cardnum,4*$i,4). ' ';          
				} 
				
				$x = 40; 
				$y = 95; 
				imagettftext($im,10,0,$x,$y,$color,$font,'序列号');    
				imagettftext($im,11,0,$x+50,$y,$color,$font_en,$p);    
				imagefilledrectangle($im,10,106,$width-10,128,$top_rectangle_color);  //填充首行
				imagefilledrectangle($im,10,129,65,$height-10,$left_rectangle_color); //填充首列          

				for($i=1;$i<=$this->str_length_col;$i++)
				{              
					$x = $i*55+35;      
					$y = 123;    
					$float_size = 11;   
					imagettftext($im,$float_size,0,$x,$y,$top_letter_color,$font_en,$info['letter']{$i-1});         
				}
				
				for($i=0;$i<$this->str_length_col;$i++)
				{              
					$linex = $i*55+65;    
					$liney = 105;    
					$liney2 = $height-10;
					imageline($im,$linex,$liney,$linex,$liney2,$linecolor);          
				}
				
				for($j=0;$j<$this->str_length_row;$j++)
				{              
					$jj=$j+1;              
					$x=35;  
					$y=($jj*24)+123; 
					imagettftext($im, $float_size, 0, $x, $y, $left_num_color, $font_en, $jj);
					for($i=1;$i<=$this->str_length_col;$i++)
					{                  
						$float_size2=11;  
						$x = $i*55+27;  
						$sy=$y;               
						$s = $info['letter']{$i-1};            
						$s .= $j + 1;            
						imagettftext($im,$float_size2,0,$x,$sy,$fontcolor,$font_en,$codes[$s]);
						echo $codes[$s];
					}     
				}          
				for($j=0;$j<$this->str_length_col;$j++)
				{              
					$line_x=10; 
					$line_x2=$width-10;
					$y=$j*24+105;
					imageline($im,$line_x,$y,$line_x2,$y,$linecolor);
				}         
         
				imageline($im,10,10,$width-10,10,$linecolor);//横线    
				imageline($im,10,10,10,$height-10,$linecolor);//竖线 
				imageline($im,$width-10,10,$width-10,$height-10,$linecolor);
				
				//生成图片          
				ob_clean();     
				header("Content-type: image/jpeg");     
				//保存为图片
				//imagejpeg($im,$this->savepath.$cardnum.".jpg",100);  
				imagejpeg($im,null,100);  
				imagedestroy($im); 
				
		   }

           //随即字母生成器
		   private function rand_str($length)
		   {
			 $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			 $rand = '';
			 for ($x=0;$x<$length;$x++)
			 {
			   $rand .= substr($string,mt_rand(0,strlen($string)-1),1);
			 }
			 return $rand;
		   }
		   
		   //随即数值生成器
		   private function rand_num($length)
		   {
			 $string = '0123456789';
			 $rand = '';
			 for ($x=0;$x<$length;$x++)
			 {
			   $rand .= substr($string,mt_rand(0,strlen($string)-1),1);
			 }
			 return $rand;
		   }		
    }

   /*
   //eg:
   $passcard = new Passcard();
   //$info里面有卡号，矩阵数据，等保存到用户关联数据记录中，即可方便后面验证使用
   $info = $passcard->get_img_data();   
   $passcard->create_passcard_img($info);
   */

?>