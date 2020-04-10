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
  user_data = <<EOF
  #cloud-config
  package_upgrade: true
  packages:
   - freeipa-client
  runcmd:
   - [ sh, -c, "hostnamectl set-hostname ${var.hostname}" ]
   - [ sh, -c , "echo nameserver 10.85.50.19 > /etc/resolv.conf"]
   - [ sh, -c, "ipa-client-install --mkhomedir -p arif@CLOUD.VSSI.COM -w 'redhat12' --server=inidmor1.cloud.vssi.com --domain cloud.vssi.com -U"]
  write_files:
  - path: /etc/pam.d/common-session
    content: |
      session	[default=1]			pam_permit.so
      session	requisite			pam_deny.so
      session	required			pam_permit.so
      session optional			pam_umask.so
      session	required pam_mkhomedir.so umask=0022 skel=/etc/skel
      session	required	pam_unix.so 
      session	optional			pam_sss.so 
      session	optional	pam_systemd.so 
EOF


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

  


}


