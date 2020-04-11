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
  key_pair        = "vdf-key1"
  security_groups = ["all-open"]
  user_data = <<EOF
  #cloud-config
  hostname: ${var.hostname}
  fqdn: ${var.hostname}
  package_upgrade: true
  packages:
   - resolvconf
   - freeipa-client
  runcmd:
    - [ sh, -c , "echo nameserver 10.85.50.19 > /etc/resolvconf/resolv.conf.d/head"]
    - [ sh, -c, "resolvconf -u" ]
    - [ sh, -c, "ipa-client-install --mkhomedir -p arif@CLOUD.VSSI.COM -w 'redhat12' --server=inidmor1.cloud.vssi.com --domain cloud.vssi.com -U"]
  write_files:
  - path: /etc/pam.d/common-session
    content: |
      session [default=1]     pam_permit.so
      session requisite     pam_deny.so
      session required      pam_permit.so
      session optional      pam_umask.so
      session required pam_mkhomedir.so umask=0022 skel=/etc/skel
      session required  pam_unix.so 
      session optional      pam_sss.so 
      session optional  pam_systemd.so 
  - path: /etc/pam.d/common-auth
    content: |
      auth  [success=2 default=ignore]  pam_unix.so nullok_secure
      auth  [success=1 default=ignore]  pam_sss.so use_first_pass
      auth  requisite     pam_deny.so
      auth  required      pam_permit.so
      auth  optional      pam_cap.so
  - path: /etc/pam.d/common-account
    content: |
      account [success=1 new_authtok_reqd=done default=ignore]  pam_unix.so 
      account requisite     pam_deny.so
      account required      pam_permit.so
      account sufficient      pam_localuser.so 
      account [default=bad success=ok user_unknown=ignore]  pam_sss.so 
  - path: /etc/pam.d/common-password
    content: |
      password  requisite     pam_pwquality.so retry=3
      password  [success=2 default=ignore]  pam_unix.so obscure use_authtok try_first_pass sha512
      password  sufficient      pam_sss.so use_authtok
      password  requisite     pam_deny.so
      password  required      pam_permit.so
      password  optional  pam_gnome_keyring.so
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


