<?php

use Illuminate\Database\Seeder;

class DropdownsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dropdowns')->delete();

        \DB::table('dropdowns')->insert(array (
            0 =>
                array (
                    'id' => '1',
                    'category_id' => '1',
                    'option_name' => 'Part A (UB-04 or 837I)',
                    'created_at' => '0000-00-00 00:00:00',
                    'updated_at' => '0000-00-00 00:00:00',
                ),
            1 =>
                array (
                    'id' => '2',
                    'category_id' => '1',
                    'option_name' => 'Part B (CMS-1500 or 837P)',
                    'created_at' => '0000-00-00 00:00:00',
                    'updated_at' => '0000-00-00 00:00:00',
                ),
            2 =>
                array (
                    'id' => '3',
                    'category_id' => '1',
                    'option_name' => 'Both',
                    'created_at' => '0000-00-00 00:00:00',
                    'updated_at' => '0000-00-00 00:00:00',
                ),
            3 =>
                array (
                    'id' => '4',
                    'category_id' => '2',
                    'option_name' => 'Advanced Practice Nurse',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            4 =>
                array (
                    'id' => '5',
                    'category_id' => '2',
                    'option_name' => 'Ambulance Service Provider and Supplier',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            5 =>
                array (
                    'id' => '6',
                    'category_id' => '2',
                    'option_name' => 'Ambulatory Surgical Center',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            6 =>
                array (
                    'id' => '7',
                    'category_id' => '2',
                    'option_name' => 'Anesthesiologist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            7 =>
                array (
                    'id' => '8',
                    'category_id' => '2',
                    'option_name' => 'Anesthesiology Assistant and Certified Registered Nurse Anesthetist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            8 =>
                array (
                    'id' => '9',
                    'category_id' => '2',
                    'option_name' => 'Audiologist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            9 =>
                array (
                    'id' => '10',
                    'category_id' => '2',
                    'option_name' => 'Chiropractor',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            10 =>
                array (
                    'id' => '11',
                    'category_id' => '2',
                    'option_name' => 'Clinical Social Worker',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            11 =>
                array (
                    'id' => '12',
                    'category_id' => '2',
                    'option_name' => 'Community Mental Health Center',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            12 =>
                array (
                    'id' => '13',
                    'category_id' => '2',
                    'option_name' => 'Comprehensive Outpatient Rehabilitation Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            13 =>
                array (
                    'id' => '14',
                    'category_id' => '2',
                    'option_name' => 'Critical Access Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            14 =>
                array (
                    'id' => '15',
                    'category_id' => '2',
                    'option_name' => 'Dentist and Oral or Maxillofacial Surgeon',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            15 =>
                array (
                    'id' => '16',
                    'category_id' => '2',
                    'option_name' => 'Doctor of Medicine or Osteopathy',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            16 =>
                array (
                    'id' => '17',
                    'category_id' => '2',
                    'option_name' => 'Durable Medical Equipment, Prosthetics, Orthotics, and Supplies',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            17 =>
                array (
                    'id' => '18',
                    'category_id' => '2',
                    'option_name' => 'End Stage Renal Disease Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            18 =>
                array (
                    'id' => '19',
                    'category_id' => '2',
                    'option_name' => 'Federally Qualified Health Center',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            19 =>
                array (
                    'id' => '20',
                    'category_id' => '2',
                    'option_name' => 'Home Health Agency',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            20 =>
                array (
                    'id' => '21',
                    'category_id' => '2',
                    'option_name' => 'Hospice',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            21 =>
                array (
                    'id' => '22',
                    'category_id' => '2',
                    'option_name' => 'Hospital (IPPS/OPPS)',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            22 =>
                array (
                    'id' => '23',
                    'category_id' => '2',
                    'option_name' => 'Independent Diagnostic Testing Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            23 =>
                array (
                    'id' => '24',
                    'category_id' => '2',
                    'option_name' => 'Inpatient Psychiatric Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            24 =>
                array (
                    'id' => '25',
                    'category_id' => '2',
                    'option_name' => 'Inpatient Rehabilitation Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            25 =>
                array (
                    'id' => '26',
                    'category_id' => '2',
                    'option_name' => 'Laboratory',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            26 =>
                array (
                    'id' => '27',
                    'category_id' => '2',
                    'option_name' => 'Long Term Care Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            27 =>
                array (
                    'id' => '28',
                    'category_id' => '2',
                    'option_name' => 'Mammography Center or Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            28 =>
                array (
                    'id' => '29',
                    'category_id' => '2',
                    'option_name' => 'Mass Immunization Roster Biller',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            29 =>
                array (
                    'id' => '30',
                    'category_id' => '2',
                    'option_name' => 'Occupational Therapist, Physical Therapist, and Speech-Language Pathologist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            30 =>
                array (
                    'id' => '31',
                    'category_id' => '2',
                    'option_name' => 'Ophthalmologist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            31 =>
                array (
                    'id' => '32',
                    'category_id' => '2',
                    'option_name' => 'Optometrist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            32 =>
                array (
                    'id' => '33',
                    'category_id' => '2',
                    'option_name' => 'Outpatient Physical Therapy, Other Rehabilitation, and Outpatient Speech Pathology Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            33 =>
                array (
                    'id' => '34',
                    'category_id' => '2',
                    'option_name' => 'Physician Assistant',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            34 =>
                array (
                    'id' => '35',
                    'category_id' => '2',
                    'option_name' => 'Podiatrist',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            35 =>
                array (
                    'id' => '36',
                    'category_id' => '2',
                    'option_name' => 'Portable X-Ray Supplier',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            36 =>
                array (
                    'id' => '37',
                    'category_id' => '2',
                    'option_name' => 'Psychiatric Unit in Critical Access Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            37 =>
                array (
                    'id' => '38',
                    'category_id' => '2',
                    'option_name' => 'Psychiatric Unit of Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            38 =>
                array (
                    'id' => '39',
                    'category_id' => '2',
                    'option_name' => 'Psychologist: Clinical and Independently Practicing',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            39 =>
                array (
                    'id' => '40',
                    'category_id' => '2',
                    'option_name' => 'Radiation Therapy Center',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            40 =>
                array (
                    'id' => '41',
                    'category_id' => '2',
                    'option_name' => 'Registered Dietitian or Nutrition Professional',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            41 =>
                array (
                    'id' => '42',
                    'category_id' => '2',
                    'option_name' => 'Rehabilitation Unit in Critical Access Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            42 =>
                array (
                    'id' => '43',
                    'category_id' => '2',
                    'option_name' => 'Rehabilitation Unit of Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            43 =>
                array (
                    'id' => '44',
                    'category_id' => '2',
                    'option_name' => 'Religious Nonmedical Health Care Institution',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            44 =>
                array (
                    'id' => '45',
                    'category_id' => '2',
                    'option_name' => 'Rural Health Clinic',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            45 =>
                array (
                    'id' => '46',
                    'category_id' => '2',
                    'option_name' => 'Skilled Nursing Facility',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            46 =>
                array (
                    'id' => '47',
                    'category_id' => '2',
                    'option_name' => 'Swing Bed Unit in Critical Access Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            47 =>
                array (
                    'id' => '48',
                    'category_id' => '2',
                    'option_name' => 'Swing Bed Unit in Hospital',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            48 =>
                array (
                    'id' => '49',
                    'category_id' => '2',
                    'option_name' => 'Transplant Center',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            49 =>
                array (
                    'id' => '50',
                    'category_id' => '2',
                    'option_name' => 'Other',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            50 =>
                array (
                    'id' => '51',
                    'category_id' => '2',
                    'option_name' => 'Not Applicable',
                    'created_at' => '2016-06-03 19:28:56',
                    'updated_at' => '2016-06-03 19:28:56',
                ),
            51 =>
                array (
                    'id' => '52',
                    'category_id' => '3',
                    'option_name' => 'J5',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            52 =>
                array (
                    'id' => '53',
                    'category_id' => '3',
                    'option_name' => 'J8',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            53 =>
                array (
                    'id' => '54',
                    'category_id' => '3',
                    'option_name' => 'J5 and J8',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            54 =>
                array (
                    'id' => '55',
                    'category_id' => '3',
                    'option_name' => 'Neither',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            55 =>
                array (
                    'id' => '56',
                    'category_id' => '4',
                    'option_name' => '01 General Practice',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            56 =>
                array (
                    'id' => '57',
                    'category_id' => '4',
                    'option_name' => '02 General Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            57 =>
                array (
                    'id' => '58',
                    'category_id' => '4',
                    'option_name' => '03 Allergy/Immunology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            58 =>
                array (
                    'id' => '59',
                    'category_id' => '4',
                    'option_name' => '04 Otolaryngology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            59 =>
                array (
                    'id' => '60',
                    'category_id' => '4',
                    'option_name' => '05 Anesthesiology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            60 =>
                array (
                    'id' => '61',
                    'category_id' => '4',
                    'option_name' => '06 Cardiology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            61 =>
                array (
                    'id' => '62',
                    'category_id' => '4',
                    'option_name' => '07 Dermatology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            62 =>
                array (
                    'id' => '63',
                    'category_id' => '4',
                    'option_name' => '08 Family Practice',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            63 =>
                array (
                    'id' => '64',
                    'category_id' => '4',
                    'option_name' => '09 Interventional Pain Management',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            64 =>
                array (
                    'id' => '65',
                    'category_id' => '4',
                    'option_name' => '10 Gastroenterology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            65 =>
                array (
                    'id' => '66',
                    'category_id' => '4',
                    'option_name' => '11 Internal Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            66 =>
                array (
                    'id' => '67',
                    'category_id' => '4',
                    'option_name' => '12 Osteopathic Manipulative Therapy',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            67 =>
                array (
                    'id' => '68',
                    'category_id' => '4',
                    'option_name' => '13 Neurology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            68 =>
                array (
                    'id' => '69',
                    'category_id' => '4',
                    'option_name' => '14 Neurosurgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            69 =>
                array (
                    'id' => '70',
                    'category_id' => '4',
                    'option_name' => '16 Obstetrics/Gynecology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            70 =>
                array (
                    'id' => '71',
                    'category_id' => '4',
                    'option_name' => '17 Hospice and Pallative Care',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            71 =>
                array (
                    'id' => '72',
                    'category_id' => '4',
                    'option_name' => '18 Ophthalmology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            72 =>
                array (
                    'id' => '73',
                    'category_id' => '4',
                    'option_name' => '19 Oral Surgery (dentists only)',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            73 =>
                array (
                    'id' => '74',
                    'category_id' => '4',
                    'option_name' => '20 Orthopedic Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            74 =>
                array (
                    'id' => '75',
                    'category_id' => '4',
                    'option_name' => '21 Cardiac Electrophysiology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            75 =>
                array (
                    'id' => '76',
                    'category_id' => '4',
                    'option_name' => '22 Pathology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            76 =>
                array (
                    'id' => '77',
                    'category_id' => '4',
                    'option_name' => '23 Sports Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            77 =>
                array (
                    'id' => '78',
                    'category_id' => '4',
                    'option_name' => '24 Plastic and Reconstructive Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            78 =>
                array (
                    'id' => '79',
                    'category_id' => '4',
                    'option_name' => '25 Physical Medicine and Rehabilitation',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            79 =>
                array (
                    'id' => '80',
                    'category_id' => '4',
                    'option_name' => '26 Psychiatry',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            80 =>
                array (
                    'id' => '81',
                    'category_id' => '4',
                    'option_name' => '27 Geriatric Psychiatry',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            81 =>
                array (
                    'id' => '82',
                    'category_id' => '4',
                    'option_name' => '28 Colorectal Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            82 =>
                array (
                    'id' => '83',
                    'category_id' => '4',
                    'option_name' => '29 Pulmonary Disease',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            83 =>
                array (
                    'id' => '84',
                    'category_id' => '4',
                    'option_name' => '30 Diagnostic Radiology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            84 =>
                array (
                    'id' => '85',
                    'category_id' => '4',
                    'option_name' => '33 Thoracic Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            85 =>
                array (
                    'id' => '86',
                    'category_id' => '4',
                    'option_name' => '34 Urology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            86 =>
                array (
                    'id' => '87',
                    'category_id' => '4',
                    'option_name' => '35 Chiropractic',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            87 =>
                array (
                    'id' => '88',
                    'category_id' => '4',
                    'option_name' => '36 Nuclear Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            88 =>
                array (
                    'id' => '89',
                    'category_id' => '4',
                    'option_name' => '37 Pediatric Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            89 =>
                array (
                    'id' => '90',
                    'category_id' => '4',
                    'option_name' => '38 Geriatric Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            90 =>
                array (
                    'id' => '91',
                    'category_id' => '4',
                    'option_name' => '39 Nephrology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            91 =>
                array (
                    'id' => '92',
                    'category_id' => '4',
                    'option_name' => '40 Hand Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            92 =>
                array (
                    'id' => '93',
                    'category_id' => '4',
                    'option_name' => '41 Optometry',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            93 =>
                array (
                    'id' => '94',
                    'category_id' => '4',
                    'option_name' => '44 Infectious Disease',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            94 =>
                array (
                    'id' => '95',
                    'category_id' => '4',
                    'option_name' => '46 Endocrinology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            95 =>
                array (
                    'id' => '96',
                    'category_id' => '4',
                    'option_name' => '48 Podiatry',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            96 =>
                array (
                    'id' => '97',
                    'category_id' => '4',
                    'option_name' => '66 Rheumatology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            97 =>
                array (
                    'id' => '98',
                    'category_id' => '4',
                    'option_name' => '72 Pain Management',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            98 =>
                array (
                    'id' => '99',
                    'category_id' => '4',
                    'option_name' => '76 Peripheral Vascular Disease',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            99 =>
                array (
                    'id' => '100',
                    'category_id' => '4',
                    'option_name' => '77 Vascular Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            100 =>
                array (
                    'id' => '101',
                    'category_id' => '4',
                    'option_name' => '78 Cardiac Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            101 =>
                array (
                    'id' => '102',
                    'category_id' => '4',
                    'option_name' => '79 Addiction Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            102 =>
                array (
                    'id' => '103',
                    'category_id' => '4',
                    'option_name' => '81 Critical Care (Intensivists)',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            103 =>
                array (
                    'id' => '104',
                    'category_id' => '4',
                    'option_name' => '82 Hematology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            104 =>
                array (
                    'id' => '105',
                    'category_id' => '4',
                    'option_name' => '83 Hematology/Oncology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            105 =>
                array (
                    'id' => '106',
                    'category_id' => '4',
                    'option_name' => '84 Preventive Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            106 =>
                array (
                    'id' => '107',
                    'category_id' => '4',
                    'option_name' => '85 Maxillofacial Surgery',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            107 =>
                array (
                    'id' => '108',
                    'category_id' => '4',
                    'option_name' => '86 Neuropsychiatry',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            108 =>
                array (
                    'id' => '109',
                    'category_id' => '4',
                    'option_name' => '88 Unknown Provider',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            109 =>
                array (
                    'id' => '110',
                    'category_id' => '4',
                    'option_name' => '90 Medical Oncology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            110 =>
                array (
                    'id' => '111',
                    'category_id' => '4',
                    'option_name' => '91 Surgical Oncology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            111 =>
                array (
                    'id' => '112',
                    'category_id' => '4',
                    'option_name' => '92 Radiation Oncology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            112 =>
                array (
                    'id' => '113',
                    'category_id' => '4',
                    'option_name' => '93 Emergency Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            113 =>
                array (
                    'id' => '114',
                    'category_id' => '4',
                    'option_name' => '94 Interventional Radiology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            114 =>
                array (
                    'id' => '115',
                    'category_id' => '4',
                    'option_name' => '98 Gynecological/Oncology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            115 =>
                array (
                    'id' => '116',
                    'category_id' => '4',
                    'option_name' => '99 Unknown Physician Specialty',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            116 =>
                array (
                    'id' => '117',
                    'category_id' => '4',
                    'option_name' => 'C0 Sleep Medicine',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
            117 =>
                array (
                    'id' => '118',
                    'category_id' => '4',
                    'option_name' => 'C3 Interventional Cardiology',
                    'created_at' => '2016-06-03 20:01:23',
                    'updated_at' => '2016-06-03 20:01:23',
                ),
        ));
    }

}

