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



provider "openstack" {
  user_name   = "admin"
  tenant_id   = var.project
  password    = "ayZma3wpahjHWgpjBRQypFUYK"
  auth_url    = "http://10.85.49.148:5000//v3"
}

resource "openstack_blockstorage_volume_v2" "volume_1" {

  name        = var.vmname
  description = var.vmname
  size        = 60
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
  key_pair        = "vdf-key1"
  security_groups = ["all-open"]


  metadata = {
       key = var.emailid
  }

  network {
    name = "nr_provider"
    fixed_ip_v4   = var.nic1
  }

  network {
    name = var.netname
     fixed_ip_v4  = var.nic2
  }

  connection {
    type = "ssh"
    user = "ubuntu"
    private_key = file(var.private_key)
    host = var.nic1
  }

  provisioner "file" {
    source = var.script_source"/startup.sh"
    destination = "/tmp/startup.sh"
  }

  provisioner "remote-exec" {
    inline = [
      "sudo hostnamectl set-hostname ${var.hostname}"
    ]
  }

  provisioner "remote-exec" {
    inline = [
      "chmod +x /tmp/startup.sh",
      "sh /tmp/startup.sh ",
      
    ]
  }


}

resource "null_resource" "ansible-main" {
  provisioner "local-exec" {
    command = "ansible-playbook -e sshKey=${var.pvt_key} -i ${var.nic1} ${var.script_source}'/ansible/install.yaml' -v "
  }

  depends_on = [openstack_compute_instance_v2.vm]
}

resource "null_resource" "ipa-setup" {
  provisioner "remote-exec" {
    inline = [
      "sudo ipa-client-install --mkhomedir -p arif@CLOUD.VSSI.COM -w 'redhat12' --server=inidmor1.cloud.vssi.com --domain cloud.vssi.com -U"
    ]
  

    connection {
    type = "ssh"
    user = "ubuntu"
    private_key = file(var.private_key)
    host = var.nic1
    }
  }

  depends_on = [null_resource.ansible-main]
}

