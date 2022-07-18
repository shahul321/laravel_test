<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration {

    /**
      # Create a migration that creates all tables for the following user stories

      For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
      To not introduce additional complexity, please consider only one cinema.

      Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

      ## User Stories

     * *Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     * *Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     * *Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     * *Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up() {
        Schema::create('movies', function ($table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('language', 55);
            $table->string('Genres', 55);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('location', function ($table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('movie_locations', function ($table) {
            $table->increments('id');
            $table->integer('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('location_id')->references('id')->on('location')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

    
        Schema::create('show_timings', function ($table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->enum('timing', array('Morning', 'Afternoon', 'Evening', 'Night'));
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('seat_categories', function ($table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->integer('seat_num_start')->unsigned();
            $table->integer('seat_num')->unsigned();
            $table->enum('type', array('vip_seat', 'couple_seat', 'super_vip'));
            $table->string('benifit_type', 150); // eg 50% for vip seat
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('seats', function ($table) {
            $table->increments('id');
            $table->string('category_id', 150)->references('id')->on('seat_categories')->onDelete('cascade');
            $table->integer('location_id')->references('id')->on('location')->onDelete('cascade');
            $table->integer('total_no_of_seats')->unsigned();
            $table->integer('availabilty_of_seats')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('price', function ($table) {
            $table->increments('id');
            $table->integer('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('location_id')->references('id')->on('location')->onDelete('cascade');
            $table->string('category_id')->references('id')->on('seat_categories')->onDelete('cascade');
            $table->string('show_id')->references('id')->on('show_timings')->onDelete('cascade');
            $table->integer('price')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('booked_hostories', function ($table) {
            $table->increments('id');
            $table->integer('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->integer('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->integer('location_id')->references('id')->on('location')->onDelete('cascade');
            $table->string('category_id')->references('id')->on('seat_categories')->onDelete('cascade');
            $table->string('show_id')->references('id')->on('show_timings')->onDelete('cascade');
            $table->string('price_id')->references('id')->on('show_timings')->onDelete('cascade');
            $table->integer('seat_no')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
    }

}
