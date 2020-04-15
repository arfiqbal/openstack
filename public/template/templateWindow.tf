variable "app" {}
variable "nic1" {}
variable "nic2" {}
variable "vmname" {}
variable "emailid" {}
variable "flavor" {}
variable "project" {}
variable "netname" {}
variable "script_source" {}
variable "private_key" {}
variable "hostname" {}
variable "jira" {}
variable "user" {}


provider "openstack" {
  user_name   = "admin"
  tenant_id   = var.project
  password    = "ayZma3wpahjHWgpjBRQypFUYK"
  auth_url    = "http://10.85.49.148:5000//v3"
}

resource "openstack_blockstorage_volume_v2" "volume_1" {

  name        = var.vmname
  description = var.vmname
  size        = 260
  image_id    = var.app
}

resource "openstack_compute_instance_v2" "vm" {
  name            = var.vmname
  block_device {
    boot_index      = 0
    source_type     = "volume"
    destination_type  = "volume"
    uuid            = openstack_blockstorage_volume_v2.volume_1.id
  }


  flavor_id       = var.flavor
  security_groups = ["all-open"]
  user_data = <<EOF
  #cloud-config
  script:      |
    <powershell>
    echo "Hello from Terraform"
    </powershell>
EOF

  

  metadata = {
       email = var.emailid
       jira = var.jira
       created_by = var.user
       created_from = "cloud-portal"
  }

  network {
    name = "nr_provider"
    fixed_ip_v4   = var.nic1
  }

  network {
    name = var.netname
     fixed_ip_v4  = var.nic2
  }

  
}

output "id" {
  value = "${openstack_compute_instance_v2.vm.id}"
}

resource "local_file" "foo" {
    content     = openstack_compute_instance_v2.vm.id
    filename = "${path.module}/outputid.json"
}




