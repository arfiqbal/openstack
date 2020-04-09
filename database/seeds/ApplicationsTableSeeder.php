<?php

use Illuminate\Database\Seeder;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('application')->insert([
           
            [ 
                "name" => "rhel-7.7" ,
                "uid" => "b1270f49-8a22-454a-9987-b67574fce1f3",
                "os" => "ubuntu"
            ],
            ["name" =>  "ciot" , "uid" => "99408b15-58cd-4183-beb8-683080abb4f8", "os" => "ubuntu"],
            ["name" => "apix" , "uid" => "2dd0a2c5-f016-478f-91cb-f21cbf516435", "os" => "ubuntu"],
            ["name" => "ce" , "uid" => "eed796c2-1067-4fd9-9a83-6fef519b33b9", "os" => "ubuntu"],
            ["name" => "gig2.5" , "uid" => "e568d597-0230-4cc3-a86e-38e5149686b3", "os" => "ubuntu"],
            ["name" => "gig2.5aaa" , "uid" => "0c2ee07e-e3ee-43df-bbf9-a7d49e9b699a", "os" => "ubuntu"],
            ["name" => "gig3.0" , "uid" => "993a27b3-8068-4935-9810-3288866e2ee1", "os" => "ubuntu"],
            ["name" => "papa" , "uid" => "c1f91aa2-cd4e-4ca8-aa32-d7f2886e0269", "os" => "ubuntu"],
            ["name" => "vision" , "uid" => "9fd2db39-9ae8-4630-9561-27d9b4307c7f", "os" => "ubuntu"],
            ["name" => "visioncentos" , "uid" => "614233c5-4893-4c53-a0bd-27b030b0cf5a", "os" => "ubuntu"],
            ["name" => "dds" , "uid" => "78ef70a5-f344-428a-920a-28e9b1a60a7e", "os" => "ubuntu"],
            ["name" => "ddswindow" , "uid" => "b10f22b2-1b0f-4af1-8856-9d5adab5be0f", "os" => "ubuntu"],
            ["name" => "er" , "uid" => "5cb16397-d5de-4b01-bb19-e2d5a13ad334", "os" => "ubuntu"],
            ["name" => "vodafoneid" , "uid" => "efb32f16-852c-4568-ae38-3678701c5e44", "os" => "ubuntu"],
            ["name" => "ppe" , "uid" => "d1dd6d3d-92ca-4916-8b6a-03d757d75dc1", "os" => "ubuntu"],
            ["name" => "sc2window" , "uid" => "5807b42d-df8d-45ac-ad52-4a2c9d0ecab7", "os" => "ubuntu"],
            ["name" => "sc2ubuntu" , "uid" => "71731999-0219-49f6-8205-5ba9a3299495", "os" => "ubuntu"],
            ["name" => "apiwizard" , "uid" => "eebebfb3-c82d-4294-9999-ea0778c8afa1", "os" => "ubuntu"],
            ["name" => "hadoopspark" , "uid" => "e3a474df-e8cb-4cdd-80f6-701f6d3edeb1", "os" => "ubuntu"],
            ["name" => "smapi" , "uid" => "5e701bfd-375a-428d-88f1-4d937c4cfa1e", "os" => "ubuntu"],
            ["name" => "start" , "uid" => "9931d672-6e10-4c38-adb3-4bcef5ee339a", "os" => "ubuntu"],
            ["name" => "dpp" , "uid" => "6fb42e63-c472-4dc7-8936-9b512f7e27ef", "os" => "ubuntu"],
            ["name" => "ubuntugui16" , "uid" => "925bcbac-380d-477e-b604-73797f736baf", "os" => "ubuntu"],
            ["name" => "ubuntugui18" , "uid" => "b2b7fccf-0cb9-4341-81bb-9e29de454fd0", "os" => "ubuntu"],
            ["name" => "ubuntucli16" , "uid" => "a66a62ae-d94e-40c4-8fba-0f2e2c1f58a5", "os" => "ubuntu"],
            ["name" => "ubuntucli18" , "uid" => "6407d9ac-9b89-4dc8-b930-197b1245cfca", "os" => "ubuntu"],
            ["name" => "window10" , "uid" => "e84f8a0f-c26f-478a-b583-54c55ffd1456", "os" => "ubuntu"],
            ["name" => "rhelcli7.7" , "uid" => "07196bf9-36ef-41af-af04-d804c2ae3113", "os" => "ubuntu"],
            ["name" => "rhelcli7.6" , "uid" => "ae4542eb-c113-4eb9-99ad-4f32684f5d74", "os" => "ubuntu"],
            ["name" => "rhelcli7.5" , "uid" => "2ffcf11b-94f9-4127-8658-2516bf860a48", "os" => "ubuntu"],
            ["name" => "rhelcli6"  , "uid" => "10880706-1646-47d6-b1c9-41474b5c0194", "os" => "ubuntu"],
            ["name" => "centos6" , "uid" => "42ca21de-eee4-4e79-8cc0-e9f8958969b8", "os" => "ubuntu"]

        ]);
    }
}
