#!/usr/bin/env bash

ansible-playbook --inventory-file=hosts_dev.ini playbook_init.yaml
ansible-playbook --inventory-file=hosts_dev.ini playbook.yaml
