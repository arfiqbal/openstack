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
        DB::table('application')->delete();
        DB::table('application')->insert([
           
        ["uid" => "eebebfb3-c82d-4294-9999-ea0778c8afa1", "version" => "16.04", "os" => "ubuntu" ,"name" => "apw"],
        ["uid" => "2dd0a2c5-f016-478f-91cb-f21cbf516435", "version" => "16.04_v1", "os" => "ubuntu" ,"name" => "ap"],
        ["uid" => "8923ab6d-c17b-488e-b22f-225242247b5d", "version" => "10_v2", "os" => "window" ,"name" => "bwindow10_v2"],
        ["uid" => "42ca21de-eee4-4e79-8cc0-e9f8958969b8", "version" => "6.9", "os" => "centos" ,"name" => "bcli_centos_6.9"],
        ["uid" => "10880706-1646-47d6-b1c9-41474b5c0194", "version" => "6.10", "os" => "rhel" ,"name" => "bcli_rhel_6.10"],
        ["uid" => "2b0aba18-edc4-493c-b9b8-3f2072767bd8", "version" => "7.5", "os" => "rhel" ,"name" => "bcli_rhel_7.5"],
        ["uid" => "ae4542eb-c113-4eb9-99ad-4f32684f5d74", "version" => "7.6", "os" => "rhel" ,"name" => "bcli_rhel_7.6"],
        ["uid" => "07196bf9-36ef-41af-af04-d804c2ae3113", "version" => "7.7", "os" => "rhel" ,"name" => "bcli_rhel_7.7"],
        ["uid" => "a66a62ae-d94e-40c4-8fba-0f2e2c1f58a5", "version" => "6.04", "os" => "ubuntu" ,"name" => "bcliu16.04"],
        ["uid" => "847178af-0835-48d1-afa0-8dc9e498f7ef", "version" => "18.04_v1", "os" => "ubuntu" ,"name" => "bcliu18.04_v1"],
        ["uid" => "6407d9ac-9b89-4dc8-b930-197b1245cfca", "version" => "18.10_v1", "os" => "ubuntu" ,"name" => "bcliu18.10_v1"],
        ["uid" => "925bcbac-380d-477e-b604-73797f736baf", "version" => "16.04_v2", "os" => "ubuntu" ,"name" => "bguiu16.04_v2"],
        ["uid" => "e1a73112-f928-450a-9af7-d0f5cac1d04a", "version" => "18.04_v1", "os" => "ubuntu" ,"name" => "bguiu18.04_v1"],
        ["uid" => "84060f9a-b40e-49d4-aa72-28c78d1d0639", "version" => "16.04", "os" => "ubuntu" ,"name" => "ce"],
        ["uid" => "eed796c2-1067-4fd9-9a83-6fef519b33b9", "version" => "18.04_v1", "os" => "ubuntu" ,"name" => "ce"],
        ["uid" => "99408b15-58cd-4183-beb8-683080abb4f8", "version" => "16.04_v5", "os" => "ubuntu" ,"name" => "ci"],
        ["uid" => "78ef70a5-f344-428a-920a-28e9b1a60a7e", "version" => "16.04_v4", "os" => "ubuntu" ,"name" => "dd"],
        ["uid" => "b10f22b2-1b0f-4af1-8856-9d5adab5be0f", "version" => "10", "os" => "window" ,"name" => "dd"],
        ["uid" => "6fb42e63-c472-4dc7-8936-9b512f7e27ef", "version" => "10", "os" => "window" ,"name" => "dp"],
        ["uid" => "5cb16397-d5de-4b01-bb19-e2d5a13ad334", "version" => "16.04", "os" => "ubuntu" ,"name" => "er"],
        ["uid" => "e568d597-0230-4cc3-a86e-38e5149686b3", "version" => "16.04_v1", "os" => "ubuntu" ,"name" => "gi"],
        ["uid" => "0c2ee07e-e3ee-43df-bbf9-a7d49e9b699a", "version" => "16.04_v4", "os" => "ubuntu" ,"name" => "gi"],
        ["uid" => "993a27b3-8068-4935-9810-3288866e2ee1", "version" => "18.04_v1", "os" => "ubuntu" ,"name" => "gi"],
        ["uid" => "e3a474df-e8cb-4cdd-80f6-701f6d3edeb1", "version" => "18.04", "os" => "ubuntu" ,"name" => "sp"],
        ["uid" => "c1f91aa2-cd4e-4ca8-aa32-d7f2886e0269", "version" => "16.04_v2", "os" => "ubuntu" ,"name" => "pa"],
        ["uid" => "d1dd6d3d-92ca-4916-8b6a-03d757d75dc1", "version" => "16.04", "os" => "ubuntu" ,"name" => "pp"],
        ["uid" => "71731999-0219-49f6-8205-5ba9a3299495", "version" => "16.04", "os" => "ubuntu" ,"name" => "sc"],
        ["uid" => "5807b42d-df8d-45ac-ad52-4a2c9d0ecab7", "version" => "10", "os" => "window" ,"name" => "sc"],
        ["uid" => "5e701bfd-375a-428d-88f1-4d937c4cfa1e", "version" => "16.04_v1", "os" => "ubuntu" ,"name" => "sm"],
        ["uid" => "9931d672-6e10-4c38-adb3-4bcef5ee339a", "version" => "16.04", "os" => "ubuntu" ,"name" => "st"],
        ["uid" => "614233c5-4893-4c53-a0bd-27b030b0cf5a", "version" => "7.5", "os" => "centos" ,"name" => "vi"],
        ["uid" => "9fd2db39-9ae8-4630-9561-27d9b4307c7f", "version" => "10", "os" => "window" ,"name" => "vi"],
        ["uid" => "efb32f16-852c-4568-ae38-3678701c5e44", "version" => "16.04_v1", "os" => "ubuntu" ,"name" => "vd"],
        ["uid" => "f3272575-72a9-491b-aa87-7a8d3c9a53e0", "version" => "18.04", "os" => "ubuntu" ,"name" => "vd"],
        ["uid" => "79f641d2-bf06-4586-9a5f-e7eda6172f24", "version" => "10", "os" => "window" ,"name" => "gp"],
        ["uid" => "1e4c4e0f-9c12-4b62-b4e6-4a17fb7d70b2", "version" => "10", "os" => "window" ,"name" => "lp"],
        ["uid" => "5a26a2cf-df3c-493d-97bb-8dbfa1be6981", "version" => "10", "os" => "window" ,"name" => "vd"],
        ["uid" => "f164b967-69ba-4dfe-b8bc-a8761ac12e10", "version" => "10", "os" => "window" ,"name" => "vu"],
        ["uid" => "3ad18fa1-a7fa-4369-9434-b8b3e3704419", "version" => "10_v1", "os" => "window" ,"name" => "pc"],
        ["uid" => "6a7b0477-cbca-48b9-9676-cb284d5885a5", "version" => "10_v1", "os" => "window" ,"name" => "sh"]

        ]);
    }
}
