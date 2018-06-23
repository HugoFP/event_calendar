#!/bin/bash
branch=$1
if [$1 eq '']
then
	echo 'Especify Branch name'
else
	git remote add origin https://github.com/HugoFP/event_calendar.git
	git push -u origin $1
fi
