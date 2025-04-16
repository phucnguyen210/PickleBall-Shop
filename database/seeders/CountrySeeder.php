<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$countries = [
			['code' => '01', 'name' => 'Hà Nội'],
			['code' => '02', 'name' => 'Hà Giang'],
			['code' => '04', 'name' => 'Cao Bằng'],
			['code' => '06', 'name' => 'Bắc Kạn'],
			['code' => '08', 'name' => 'Tuyên Quang'],
			['code' => '10', 'name' => 'Lào Cai'],
			['code' => '11', 'name' => 'Điện Biên'],
			['code' => '12', 'name' => 'Lai Châu'],
			['code' => '14', 'name' => 'Sơn La'],
			['code' => '15', 'name' => 'Yên Bái'],
			['code' => '17', 'name' => 'Hòa Bình'],
			['code' => '19', 'name' => 'Thái Nguyên'],
			['code' => '20', 'name' => 'Lạng Sơn'],
			['code' => '22', 'name' => 'Quảng Ninh'],
			['code' => '24', 'name' => 'Bắc Giang'],
			['code' => '25', 'name' => 'Phú Thọ'],
			['code' => '26', 'name' => 'Vĩnh Phúc'],
			['code' => '27', 'name' => 'Bắc Ninh'],
			['code' => '30', 'name' => 'Hải Dương'],
			['code' => '31', 'name' => 'Hải Phòng'],
			['code' => '33', 'name' => 'Hưng Yên'],
			['code' => '34', 'name' => 'Thái Bình'],
			['code' => '35', 'name' => 'Hà Nam'],
			['code' => '36', 'name' => 'Nam Định'],
			['code' => '37', 'name' => 'Ninh Bình'],
			['code' => '38', 'name' => 'Thanh Hóa'],
			['code' => '40', 'name' => 'Nghệ An'],
			['code' => '42', 'name' => 'Hà Tĩnh'],
			['code' => '44', 'name' => 'Quảng Bình'],
			['code' => '45', 'name' => 'Quảng Trị'],
			['code' => '46', 'name' => 'Thừa Thiên Huế'],
			['code' => '48', 'name' => 'Đà Nẵng'],
			['code' => '49', 'name' => 'Quảng Nam'],
			['code' => '51', 'name' => 'Quảng Ngãi'],
			['code' => '52', 'name' => 'Bình Định'],
			['code' => '54', 'name' => 'Phú Yên'],
			['code' => '56', 'name' => 'Khánh Hòa'],
			['code' => '58', 'name' => 'Ninh Thuận'],
			['code' => '60', 'name' => 'Bình Thuận'],
			['code' => '62', 'name' => 'Kon Tum'],
			['code' => '64', 'name' => 'Gia Lai'],
			['code' => '66', 'name' => 'Đắk Lắk'],
			['code' => '67', 'name' => 'Đắk Nông'],
			['code' => '68', 'name' => 'Lâm Đồng'],
			['code' => '70', 'name' => 'Bình Phước'],
			['code' => '72', 'name' => 'Tây Ninh'],
			['code' => '74', 'name' => 'Bình Dương'],
			['code' => '75', 'name' => 'Đồng Nai'],
			['code' => '77', 'name' => 'Bà Rịa - Vũng Tàu'],
			['code' => '79', 'name' => 'TP. Hồ Chí Minh'],
			['code' => '80', 'name' => 'Long An'],
			['code' => '82', 'name' => 'Tiền Giang'],
			['code' => '83', 'name' => 'Bến Tre'],
			['code' => '84', 'name' => 'Trà Vinh'],
			['code' => '86', 'name' => 'Vĩnh Long'],
			['code' => '87', 'name' => 'Đồng Tháp'],
			['code' => '89', 'name' => 'An Giang'],
			['code' => '91', 'name' => 'Kiên Giang'],
			['code' => '92', 'name' => 'Cần Thơ'],
			['code' => '93', 'name' => 'Hậu Giang'],
			['code' => '94', 'name' => 'Sóc Trăng'],
			['code' => '95', 'name' => 'Bạc Liêu'],
			['code' => '96', 'name' => 'Cà Mau'],
		];

		DB::table('countries')->insert($countries);
	}
}
