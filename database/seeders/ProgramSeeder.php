<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            ['code' => 'BSIT', 'program' => 'BS in Information Technology', 'description' => 'Develop the sought-after skills in the competitive IT industry with the Bachelor of Science in Information Technology program. Gain a great command of scripting and programming languages and train in hardware and software management, among many of the core subjects. BSIT graduates will be ready to innovate with high-quality and complex infrastructures that make a difference in any business organization.',
            'created_at' => now(), 'updated_at' => now()],  
            ['code' => 'BSCS', 'program' => 'BS in Computer Science', 'description' => 'Be at the forefront of emerging technology with the Bachelor of Science in Computer Science program. Build a solid foundation in programming, software engineering, algorithm development, computer architecture, operating systems and networks through the latest software tools and industry standard technologies. BSCS graduates will be equipped with strong technical skills to innovate computing solutions and programs across various industries.',
            'created_at' => now(), 'updated_at' => now()],  
            ['code' => 'BSBA', 'program' => 'BS in Business Administration', 'description' => 'Lead business ventures as a highly capable professional with the Bachelor of Science in Business Administration program. Develop an in-depth understanding of the operations of manufacturing, agribusiness, service enterprises, and all the aspects of operation within the organization. Its comprehensive curriculum combined with learning materials from industry partners will ready BSBA graduates for business.',
            'created_at' => now(), 'updated_at' => now()],  
            ['code' => 'BSHM', 'program' => 'BS in Hospitality Management', 'description' => 'Be a world-class hospitality professional with the Bachelor of Science in Hospitality Management program, formerly the BS Hotel and Restaurant Management program. Experience real life training in industry-standard simulation laboratories and gain competencies in hotel and restaurant management. BSHM graduates will be ready for the culinary world as well as the hospitality industry here and abroad.',
            'created_at' => now(), 'updated_at' => now()],  
            ['code' => 'BSHM', 'program' => 'BS in Hospitality Management', 'description' => 'Be a world-class hospitality professional with the Bachelor of Science in Hospitality Management program, formerly the BS Hotel and Restaurant Management program. Experience real life training in industry-standard simulation laboratories and gain competencies in hotel and restaurant management. BSHM graduates will be ready for the culinary world as well as the hospitality industry here and abroad.',
            'created_at' => now(), 'updated_at' => now()],  
            ['code' => 'BSCE', 'program' => 'BS in Computer Engineering', 'description' => "Build tomorrow's technology with the Bachelor of Science in Computer Engineering program. The four-year program will immerse you in the field of modern computer systems, data communications, computer systems architecture, and software development, among others. BSCpE graduates will be ready to invent the next generation of technology.",
            'created_at' => now(), 'updated_at' => now()],  
            ['code' => 'BACOMM', 'program' => 'BA in Communication', 'description' => 'Produce groundbreaking ideas and make your voice be heard with the Bachelor of Arts in Communication program. Develop a wide range of skills in radio/television/film production, journalism and broadcasting, integrated marketing research, and digital media, among others. BACOMM graduates are ready to inspire with stories.',
            'created_at' => now(), 'updated_at' => now()],  
        ];

        DB::table('programs')->insert($programs);
    }
}
