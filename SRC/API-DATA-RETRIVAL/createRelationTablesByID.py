
# coding: utf-8

import csv
from collections import OrderedDict

# load name:id to dict
def insertToDict (data,dict,colnum,isTop):
    headline=data.pop(0)
    nameIndex=-1
    idIndex=-1
    wikiIndex=-1
    for i in range (0,len(headline)):
        if headline[i]=="name":
            nameIndex=i
        if headline[i]=="ID":
            idIndex=i
        if headline[i]=="wikiPageID":
            wikiIndex=i
    if nameIndex<0 or idIndex<0 or (not isTop and wikiIndex<0):
        print ("Error: file's headline not as expected!\n")
        print (headline)
        exit(0)
    for row in data:
        try:
            if colnum==1: # id for col 1 and name for col 2
                iden=row[wikiIndex]
            else:
                iden=row[nameIndex]
            id=row[idIndex]
            dict[iden]=id
        except:
            print ("Error: defected row!\n")
            print(row)
            exit(0)
    return dict


# send relation files to ID files and check credability
def createByID(DataDir,fileData1,fileData2,relDir,fileRelation,DirOutput,fileOutputName,isTop):

    fileData1=DataDir+"/"+fileData1+".csv"
    with open(fileData1) as f:
        data1 = list(csv.reader(f))
        f.close
    dict1=OrderedDict()
    if isTop:
        insertToDict(data1,dict1,2,isTop)
    else:
        insertToDict(data1,dict1,1,isTop)

    fileData2=DataDir+"/"+fileData2+".csv"
    with open(fileData2) as f:
        data2 = list(csv.reader(f))
        f.close
    dict2=OrderedDict()
    insertToDict(data2,dict2,2,isTop)

    fileRelation=relDir+"/"+fileRelation+".csv"
    with open (fileRelation) as f:
        datar=list(csv.reader(f))
        f.close()
    headline=datar.pop(0)

    fileOutput=DirOutput+"/"+fileOutputName+".csv" #output file
    with open(fileOutput,'w') as f:
        idx=2
        if isTop:
            idx=1
            f.write("{0},{1}\n".format(headline[0],headline[1]))
        else:
            f.write("{0},{1}\n".format(headline[1],headline[2]))
        for row in datar:
            if row[0] in dict1: #by id
                if row[idx] in dict2: #by name
                    id1=dict1[row[0]]
                    id2=dict2[row[idx]]
                    f.write("{0},{1}\n".format(id1,id2))
        f.close



