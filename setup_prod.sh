#!/usr/bin/env bash

ansible-playbook --inventory-file=hosts_prod.ini playbook_init.yaml
ansible-playbook --inventory-file=hosts_prod.ini playbook.yaml
