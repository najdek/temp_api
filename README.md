# TEMPERATURE DATABASE API #

### Add new room to database (not included in api yet): ###
``CREATE TABLE `temp`.`ROOMNAME` ( `datetime` DATETIME NOT NULL , `temperature` INT(5,2) NOT NULL , UNIQUE (`datetime`)) ENGINE = InnoDB;``


### Add current temperature to database: ###
`add.php?key=ADDKEY&room=ROOMNAME&temp=23.45`



### Get latest saved room temperature: ###
`get.php?key=GETKEY&room=ROOMNAME&last`

Example return:
```
{"2018-09-12 19:21:03":"26.69"}
```

### Get saved room temperatures for specified period of time: ###
`get.php?key=GETKEY&room=ROOMNAME&from=2018.09.08-18:26:00&to=2018.09.13-19:15:00`

*Specified period of time can't be longer than a month.*

Example return:
```
{
  "2018-09-12 19:15:02":"26.69",
  "2018-09-12 19:16:02":"26.62",
  "2018-09-12 19:17:02":"26.69",
  "2018-09-12 19:18:02":"26.62",
  "2018-09-12 19:19:03":"26.62"
}
```