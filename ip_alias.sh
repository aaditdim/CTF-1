#!/bin/bash
for i in `seq $1`
do
	x=$(( $RANDOM % 255 ))
	y=$(( $RANDOM % 255 ))
	z=$(( $RANDOM % 255 ))
	sudo ifconfig eth4:$x 1.$z.$y.$x up 
done
