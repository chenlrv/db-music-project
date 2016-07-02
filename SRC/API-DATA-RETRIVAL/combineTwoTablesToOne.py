
# coding: utf-8

import csv
import os
import unicodecsv


# create one table with ID
def combineTwoWithID(dirpath,outputPath,filename1,filename2,newfilename):
    filepath1=dirpath+"/"+filename1+".csv"
    filepath2=dirpath+"/"+filename2+".csv"
    with open(filepath1) as f:
        data1 = list(csv.reader(f))
        f.close
    with open(filepath2) as f:
        data2 = list(csv.reader(f))
        f.close
    data1.reverse
    data2.reverse
    data2.pop(0)
    filepath=outputPath+"/"+newfilename+".csv"
    with open(filepath,'w') as f:
        j=0
        for row in data1:
            for item in row:
                f.write("{0},".format(item))
            if j==0:
                f.write("ID\n")
            else:
                f.write("{0}\n".format(j))
            j+=1
        for row in data2:
            for item in row:
                f.write("{0},".format(item))
            f.write("{0}\n".format(j))
            j+=1
        f.close()

# create one table without ID
def combineTwo(dirpath,outputPath,filename1,filename2,newfilename):
    filepath1=dirpath+"/"+filename1+".csv"
    filepath2=dirpath+"/"+filename2+".csv"
    with open(filepath1) as f:
        data1 = list(csv.reader(f))
        f.close
    with open(filepath2) as f:
        data2 = list(csv.reader(f))
        f.close
    data1.reverse
    data2.reverse
    data2.pop(0)
    filepath=outputPath+"/"+newfilename+".csv"
    with open(filepath,'w') as f:
        for row in data1:
            for item in row:
                f.write("{0},".format(item))
            f.write("\n")
        for row in data2:
            for item in row:
                f.write("{0},".format(item))
            f.write("\n")
        f.close()



