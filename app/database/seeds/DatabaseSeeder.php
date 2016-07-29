<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CareerTableSeeder');
	}

}

class CareerTableSeeder extends Seeder{
	public function run(){
		DB::table('careers')->insert(array(
			'code' => 7300,
			'name' => 'Ing. Civil Informática'
		));

		DB::table('careers')->insert(array(
			'code' => 5613,
			'name' => 'Ing. Civil de Minas'
		));
	}
}


