#!/bin/bash
for i in `seq $1`
do
	x=$(( $RANDOM % 255 ))
	sudo ifconfig eth4:$x 1.1.1.$x up 
done
