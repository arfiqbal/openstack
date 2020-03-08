variable "app" {}
variable "nic1" {}
variable "nic2" {}
variable "vmname" {}
variable "emailid" {}



provider "openstack" {
  user_name   = "admin"
  tenant_name = "cpns"
  password    = "ayZma3wpahjHWgpjBRQypFUYK"
  auth_url    = "http://10.85.49.148:5000/v2.0"
}

resource "openstack_blockstorage_volume_v1" "volume_1" {

  name        = var.vmname
  description = var.vmname
  size        = 260
  image_id    = var.app
}

resource "openstack_compute_instance_v2" "cpns" {
  name            = var.vmname
  block_device {
    boot_index      = 0
    source_type     = "volume"
    destination_type  = "volume"
    uuid            = openstack_blockstorage_volume_v1.volume_1.id
  }

  flavor_id       = "58420862-09c7-4c38-8b2e-269ca24a66ad"
  key_pair        = "vdf-key1"
  security_groups = ["all-open"]


  metadata = {
       key = var.emailid
  }

  network {
    name = "nr_provider"
    fixed_ip_v4    = var.nic1
  }

  network {
    name = "vssi_routable"
     fixed_ip_v4    = var.nic2
  }

}

