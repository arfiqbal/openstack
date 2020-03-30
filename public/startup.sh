#!/bin/bash

sudo sh -c "echo nameserver 10.85.50.19 > /etc/resolv.conf"

DISTRO=$(cat /etc/*-release | grep -w NAME | cut -d= -f2 | tr -d '"')

if [ "$DISTRO"=="Ubuntu"  ] ; then

    sudo apt-get update -y
    export DEBIAN_FRONTEND=noninteractive
    sudo -E apt -y -qq install freeipa-client
    unset DEBIAN_FRONTEND

elif [ "$DISTRO"=="CentOS" ] ; then

    sudo apt-get update -y
    sudo yum install ipa-client -y 
    
fi
