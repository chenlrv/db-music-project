
# coding: utf-8

import csv
import os
import numpy as np
import unicodecsv


# check type of values in each coulumn
def checkType(data):
    newData=list(data)
    valueTypeArray=newData.pop(0)
    valueTypeArray=[0 for i in range (0,len(valueTypeArray))]
    for row in newData:
        for i in range (0,len(row)):
            item=row[i]
            try: 
                int(item)
            except ValueError:
                try:
                    if valueTypeArray[i]==0:
                        valueTypeArray[i]=1
                    valueTypeArray[i]=max(valueTypeArray[i],len(item))
                except:
                    print("Error: defected row. row is too short!\n")
                    print(row)
                    exit(0)
    return valueTypeArray

# write the sql file from data file
def writeDataSqlFile(f,data,tableName,valueTypeArray):
    
    f.write("CREATE TABLE {0} (\n".format(tableName))
    headline=data.pop(0)
        
    # create table
    f.write("\tID INT NOT NULL,\n".format(len(data)+1))
    for i in range (0,len(headline)-1):
        item=headline[i]
        if valueTypeArray[i]==0:
            f.write("\t{0} INT,\n".format(item))
        else:
            if "comment" in item or "discription" in item or valueTypeArray[i]>1500:
                f.write("\t{0} TEXT,\n".format(item))
            elif item=="name":
                valueTypeArray[i]+=16
                f.write("\t{0} VARCHAR({1}) NOT NULL,\n".format(item,valueTypeArray[i]))
            else:
                valueTypeArray[i]+=16
                f.write("\t{0} VARCHAR({1}),\n".format(item, valueTypeArray[i]))
    f.write("\tPRIMARY KEY (ID)\n")
    f.write(");\n\n")
        
    # insert values to table    
    for row in data:
        printrow=True
        if printrow:
            f.write("INSERT INTO {0} VALUES ({1},".format(tableName,row[len(row)-1]))
            for i in range (0,len(row)-1):
                item=row[i]
                item=item.replace("\'","\''")
                if valueTypeArray[i]==0:
                    item=int(item)
                    f.write("%d" % item)
                else:
                    if item=='NULL':
                        f.write(item)
                    else:
                        f.write('\'')
                        f.write(item)
                        f.write('\'')
                if i<len(headline)-2:
                    f.write(",")
            f.write(");\n")
    f.write("\n")

    f.write("ALTER TABLE {0} MODIFY ID INT NOT NULL AUTO_INCREMENT;\n".format(tableName))
    f.write("ALTER TABLE {0} AUTO_INCREMENT = {1};\n\n".format(tableName,len(data)+1))


# write the sql file from match file
def writeMatchSqlFile(f,data,tableName,valueTypeArray):
   
    f.write("CREATE TABLE {0} (\n".format(tableName))
    headline=data.pop(0)
        
    # create table
    for i in range (0,len(headline)):
        item=headline[i]
        f.write("\t{0} INT\n".format(item))
        refTable=tableName.split("_")[i]
        if "Genre" in refTable and "Top" not in refTable:
            refTable="MusicGenre"
        f.write("\t\tREFERENCES {0}(ID)".format(refTable))
        if i<len(headline)-1:
            f.write (',\n')
        else:
            f.write ('\n')
    f.write(");\n\n")
        
    # insert values to table

    for row in data:
        f.write("INSERT INTO {0} VALUES (".format(tableName))
        for i in range (0,len(row)):
            item=row[i]
            item=int(item)
            f.write("%d" % item)
            if i<len(headline)-1:
                f.write(",")
        f.write(");\n")
    f.write("\n")


# create tables from dir
def createDataTable(f,dirpath):
    for filename in os.listdir(dirpath):
        filepath=dirpath+'/'+filename
        tableName=filename.split('.csv')[0]
        if tableName == "Song" or tableName == "Single":
            continue
        with open(filepath) as f2:
            data = list(csv.reader(f2))
            data.reverse
            f2.close
        valueTypeArray=checkType(data)
        writeDataSqlFile(f,data,tableName,valueTypeArray)



# create tables from dir
def createMatchTable(f,dirpath):
    for filename in os.listdir(dirpath):
        filepath=dirpath+'/'+filename
        tableName=filename.split('.csv')[0]
        if tableName == "Song" or tableName == "Single":
            continue
        with open(filepath) as f2:
            data = list(csv.reader(f2))
            data.reverse
            f2.close
        valueTypeArray=checkType(data)
        writeMatchSqlFile(f,data,tableName,valueTypeArray)


# write index file
def createIndex(f,dir1,dir2):
        for filename in os.listdir(dir1):
            tableName=filename.split('.csv')[0]
            if tableName == "Song" or tableName == "Single":
                continue
            field="ID"
            f.write("CREATE INDEX idIndex ON {0}({1});\n".format(tableName,field))
        for filename in os.listdir(dir2):
            with open (dir2+"/"+filename,"r") as tf:
                field=str(tf.readline()).replace("\n","")
                field=field.split(",")
                tf.close
            tableName=filename.split('.csv')[0]
            f.write("CREATE INDEX idIndex1 ON {0}({1});\n".format(tableName,field[0]))
            f.write("CREATE INDEX idIndex2 ON {0}({1});\n".format(tableName,field[1]))


# write all DB building queries into one SQL_DB file
def createSQLTables(dir1 ,dir2):
    outputSQL="SQL_DB/CREATE-DB-SCRIPT.sql"
    with open(outputSQL,'w') as f:
            createDataTable(f,dir1)
            createMatchTable(f,dir2)
            createIndex(f,dir1,dir2)
            f.close