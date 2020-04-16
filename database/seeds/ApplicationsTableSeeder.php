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
           
        ["uid" => "eebebfb3-c82d-4294-9999-ea0778c8afa1", "os" => "ubuntu" ,"name" => "apiwizard"],
        ["uid" => "2dd0a2c5-f016-478f-91cb-f21cbf516435", "os" => "ubuntu" ,"name" => "apix"],
        ["uid" => "8923ab6d-c17b-488e-b22f-225242247b5d", "os" => "window" ,"name" => "bwindow10_v2"],
        ["uid" => "42ca21de-eee4-4e79-8cc0-e9f8958969b8", "os" => "centos" ,"name" => "bcli_centos_6.9"],
        ["uid" => "10880706-1646-47d6-b1c9-41474b5c0194", "os" => "rhel" ,"name" => "bcli_rhel_6.10"],
        ["uid" => "2b0aba18-edc4-493c-b9b8-3f2072767bd8", "os" => "rhel" ,"name" => "bcli_rhel_7.5"],
        ["uid" => "ae4542eb-c113-4eb9-99ad-4f32684f5d74", "os" => "rhel" ,"name" => "bcli_rhel_7.6"],
        ["uid" => "07196bf9-36ef-41af-af04-d804c2ae3113", "os" => "rhel" ,"name" => "bcli_rhel_7.7"],
        ["uid" => "a66a62ae-d94e-40c4-8fba-0f2e2c1f58a5", "os" => "ubuntu" ,"name" => "bcliu16.04"],
        ["uid" => "847178af-0835-48d1-afa0-8dc9e498f7ef", "os" => "ubuntu" ,"name" => "bcliu18.04_v1"],
        ["uid" => "6407d9ac-9b89-4dc8-b930-197b1245cfca", "os" => "ubuntu" ,"name" => "bcliu18.10_v1"],
        ["uid" => "925bcbac-380d-477e-b604-73797f736baf", "os" => "ubuntu" ,"name" => "bguiu16.04_v2"],
        ["uid" => "e1a73112-f928-450a-9af7-d0f5cac1d04a", "os" => "ubuntu" ,"name" => "bguiu18.04_v1"],
        ["uid" => "84060f9a-b40e-49d4-aa72-28c78d1d0639", "os" => "ubuntu" ,"name" => "ce_u16.04"],
        ["uid" => "eed796c2-1067-4fd9-9a83-6fef519b33b9", "os" => "ubuntu" ,"name" => "ce_u18.04_v1"],
        ["uid" => "99408b15-58cd-4183-beb8-683080abb4f8", "os" => "ubuntu" ,"name" => "ciot"],
        ["uid" => "78ef70a5-f344-428a-920a-28e9b1a60a7e", "os" => "ubuntu" ,"name" => "ddsu"],
        ["uid" => "b10f22b2-1b0f-4af1-8856-9d5adab5be0f", "os" => "window" ,"name" => "ddsw"],
        ["uid" => "6fb42e63-c472-4dc7-8936-9b512f7e27ef", "os" => "window" ,"name" => "dppw"],
        ["uid" => "5cb16397-d5de-4b01-bb19-e2d5a13ad334", "os" => "ubuntu" ,"name" => "erubuntu"],
        ["uid" => "e568d597-0230-4cc3-a86e-38e5149686b3", "os" => "ubuntu" ,"name" => "gig2.5u_16.04_v1"],
        ["uid" => "0c2ee07e-e3ee-43df-bbf9-a7d49e9b699a", "os" => "ubuntu" ,"name" => "gig2.5aaau_16.04"],
        ["uid" => "993a27b3-8068-4935-9810-3288866e2ee1", "os" => "ubuntu" ,"name" => "gig3.0u_18.04_v1"],
        ["uid" => "e3a474df-e8cb-4cdd-80f6-701f6d3edeb1", "os" => "ubuntu" ,"name" => "hadoop_spark_ubuntu_18.04_v0"],
        ["uid" => "c1f91aa2-cd4e-4ca8-aa32-d7f2886e0269", "os" => "ubuntu" ,"name" => "papa"],
        ["uid" => "d1dd6d3d-92ca-4916-8b6a-03d757d75dc1", "os" => "ubuntu" ,"name" => "ppe"],
        ["uid" => "71731999-0219-49f6-8205-5ba9a3299495", "os" => "ubuntu" ,"name" => "sc2u"],
        ["uid" => "5807b42d-df8d-45ac-ad52-4a2c9d0ecab7", "os" => "window" ,"name" => "sc2w"],
        ["uid" => "5e701bfd-375a-428d-88f1-4d937c4cfa1e", "os" => "ubuntu" ,"name" => "smapiu"],
        ["uid" => "9931d672-6e10-4c38-adb3-4bcef5ee339a", "os" => "ubuntu" ,"name" => "startu"],
        ["uid" => "614233c5-4893-4c53-a0bd-27b030b0cf5a", "os" => "centos" ,"name" => "vision_centos_7.5"],
        ["uid" => "9fd2db39-9ae8-4630-9561-27d9b4307c7f", "os" => "window" ,"name" => "visionwindow_10"],
        ["uid" => "efb32f16-852c-4568-ae38-3678701c5e44", "os" => "ubuntu" ,"name" => "vodafoneid_ubuntu_16.04_v1"],
        ["uid" => "f3272575-72a9-491b-aa87-7a8d3c9a53e0", "os" => "ubuntu" ,"name" => "vodafoneid_ubuntu_18.04_v0"],
        ["uid" => "79f641d2-bf06-4586-9a5f-e7eda6172f24", "os" => "window" ,"name" => "adcws_GPF_window_10_v0"],
        ["uid" => "1e4c4e0f-9c12-4b62-b4e6-4a17fb7d70b2", "os" => "window" ,"name" => "adcws_LPE_window_10_v0"],
        ["uid" => "5a26a2cf-df3c-493d-97bb-8dbfa1be6981", "os" => "window" ,"name" => "adcws_VBO_window_10_v0"],
        ["uid" => "f164b967-69ba-4dfe-b8bc-a8761ac12e10", "os" => "window" ,"name" => "adcws_VU_window_10_v0"],
        ["uid" => "3ad18fa1-a7fa-4369-9434-b8b3e3704419", "os" => "window" ,"name" => "adcws_pace_window_10_v1"],
        ["uid" => "6a7b0477-cbca-48b9-9676-cb284d5885a5", "os" => "window" ,"name" => "adcws_share_window_10_v1"]

        ]);
    }
}
