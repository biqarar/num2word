<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 * @version 1.0.1;
 * @date 1395-05-15
 */
class num2word
{
	public $yekan,$dahgan,$dahtadahta,$sadtasadta;
	public $value;
	public $count_num;
	public $result = [];
	public $number;
	public $manfi  = false;

	public $s         = " ";
	public $sp        = ",";
	public $and       = " و ";
	public $manfi_str = " منفی ";

	public function __construct()
	{
		$this->count_str =
		[
			1 => "",
			2 => "هزار",
			3 => "ملیون",
			4 => "ملیارد",
			5 => "بیلیون",
			6 => "تریلیون",
			7 => "کوادلیلیون",
			8 => "کوینتیلیون",
			// 9 => "add name for convert :))",
		];
		$this->max_num = count($this->count_str) * 3;
	}


	private function config()
	{
		$this->yekan =
		[
			'صفر',
			'یک',
			'دو',
			'سه',
			'چهار',
			'پنج',
			'شش',
			'هفت',
			'هشت',
			'نه'
		];

		$this->dahgan =
		[
			11 => 'یازده',
			12 =>'دوازده',
			13 => 'سیزده',
			14 =>'چهارده',
			15 =>'پانزده',
			16 =>'شانزده',
			17 =>'هفده',
			18 =>'هجده',
			19 =>'نوزده'
		];

		$this->dahtadahta =
		[
			1 =>'ده',
			2 =>'بیست',
			3 => 'سی',
			4 =>'چهل',
			5 => 'پنجاه',
			6 => 'شصت',
			7 =>'هفتاد',
			8 =>'هشتاد',
			9 =>'نود'
		];

		$this->sadtasadta =
		[
			1 =>'صد',
			2 =>'دویست',
			3 =>'سیصد',
			4 =>'چهارصد',
			5 =>'پانصد',
			6 =>'ششصد',
			7 =>'هفتصد',
			8 =>'هشتصد',
			9 => 'نهصد'
		];

		$x               = $this->Xnumber_format($this->value);
		$this->number    = ($this->manfi) ? "-" . $x : $x;
		$this->split     = explode(",", $x);
		$this->count_num = count($this->split);
		$this->i         = $this->count_num;
		$this->compile();
	}


	private function clean()
	{
		$this->value     = null;
		$this->count_num = null;
		$this->result    = null;
		$this->number    = null;
		$this->manfi     = false;
	}


	private function Xnumber_format($value = false)
	{
		while (preg_match("/^0/", $value) && $value != 0)
		{
			$value = preg_replace("/^0/", "", $value);
		}

		$split = str_split($value);

		$n = "";
		for ($i=count($split) -1; $i >= 0  ; $i = $i - 3)
		{
			$n .= $split[$i] . $split[$i-1] . $split[$i-2]. $this->sp;
		}

		$n = strrev($n);
		$n = preg_replace("/^\,/", "", $n);
		return $n;
	}


	public function convert($value = false)
	{
		$this->clean();

		if(strlen($value) > $this->max_num)
		{
			return "<a style='color:red'>عدد وارد شده نباید بیشتر از {$this->max_num} رقم باشد</a>";
		}

		$value = preg_replace("/\,/", "", $value);

		if(preg_match("/^(\-\d+)|(\d+\-)$/", $value))
		{
			$this->manfi = true;
			$value       = preg_replace("/\-/", "", $value);
			if($value == 0)
			{
				$this->manfi = false;
			}
		}

		if(!preg_match("/^\d+$/", $value))
		{
			return "<a style='color:red'>لفطا فقط از کاراکتر های عددی استفاده کنید</a>";
		}

		$this->value = $value;

		$this->config();

		$return = join($this->result, $this->and);

		return ($this->manfi) ? $this->manfi_str . $return : $return;
	}


	private function n1($n = false)
	{
		return $this->yekan[$n];
	}


	private function n2($n = false)
	{
		$c = str_split($n);
		if(floatval($n) < 20 && floatval($n) > 10)
		{
			return  $this->dahgan[$n];
		}

		if($c[1] == 0)
		{
			return  $this->dahtadahta[$c[0]];
		}

		$dahgan = $this->dahtadahta[$c[0]];
		$yekan = $this->n1($c[1]);
		return  $dahgan . $this->and . $yekan;

	}


	private function nc1($n = false)
	{
		$this->result[] = $this->n1($n) . $this->s  . $this->count_str[$this->i];
	}


	private function nc2($n = false)
	{
		$this->result[] = $this->n2($n) . $this->s  . $this->count_str[$this->i];
	}


	private function nc3($n = false)
	{
		$c = str_split($n);

		$sadgan = $this->sadtasadta[$c[0]];
		$dahgan = $this->dahtadahta[$c[1]];
		$yekan  = $this->n1($c[2]);

		if($c[0] == 0)
		{
			$sadgan = false;
			$dahgan = $this->n2("{$c[1]}{$c[2]}");
			$yekan  = false;
		}

		if($c[1] == 0)
		{
			$sadgan = $this->sadtasadta[$c[0]];
			$dahgan = false;
			$yekan  = $this->n1($c[2]);
		}

		if($c[2] == 0)
		{
			$sadgan = $this->sadtasadta[$c[0]];
			$dahgan = $this->dahtadahta[$c[1]];
			$yekan  = false;
		}

		if($c[0] == 0 && $c[1] == 0)
		{
			$sadgan = false;
			$dahgan = false;
			$yekan  = $this->n1($c[2]);
		}

		if($c[1] == 0 && $c[2] == 0)
		{
			$sadgan = $this->sadtasadta[$c[0]];
			$dahgan = false;
			$yekan  = false;
		}

		if($c[0] == 0 && $c[1] == 0 && $c[2] == 0)
		{
			$sadgan = false;
			$dahgan = false;
			$yekan  = false;
		}

		if($c[1] == 1)
		{
			$sadgan = $this->sadtasadta[$c[0]];
			$dahgan = $this->n2("{$c[1]}{$c[2]}");
			$yekan  = false;
		}

		$str = null;
		$run = false;

		if($sadgan)
		{
			$str .=  $sadgan;
			$run  = true;
		}

		if($dahgan)
		{
			$str .= (($sadgan || $yekan) ? $this->and : "")  . $dahgan;
			$run  = true;
		}

		if($yekan)
		{
			$str .= (($sadgan || $dahgan) ? $this->and : "") . $yekan;
			$run  = true;
		}

		if($run)
		{
			$this->result[] = $str . $this->s .$this->count_str[$this->i];
		}
	}


	private function compile()
	{
		foreach ($this->split as $key => $value)
		{
			$c = strlen($value);
			switch ($c)
			{
				case 1:
					$this->nc1($value);
					break;
				case 2:
					$this->nc2($value);
					break;
				case 3:
					$this->nc3($value);
					break;
			}
			$this->i--;
		}
	}
}
?>
