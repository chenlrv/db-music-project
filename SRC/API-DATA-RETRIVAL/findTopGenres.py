
# coding: utf-8

# In[62]:

import numpy as np
import csv
import os
from collections import OrderedDict

dictDer=OrderedDict()
dictFus=OrderedDict()
dictOrg=OrderedDict()
dictSub=OrderedDict()

topGenres=['Pop','Rock','Metal','Hip hop','Rap','Reggae','Jazz','House','Folk','Country','Disco','Soul','Techno',
           'Blues','A cappella','New wave','Gospel','Ambient','Latin','Hardcore','Industrial',
           'Punc','Punk','Funk','Tradition','World','Electro','Swing','Samba','Noise','Dance',
           'National','Thrash','Soundtrack','Lo-fi','Ancient','Garage','Experimental','Boogie',
           'Calypso','Celtic','Indie','Indo']

def insertToDict (filepath,dict):
    with open(filepath) as f:
        data = list(csv.reader(f))
        f.close
    headline=data.pop(0)
    for row in data:
        try:
            name=row[0].lower()
            match=row[1].lower()
            if name not in dict:
                dict[name]=[match]
            else:
                dict[name].append(match)
        except:
            print ("Error: defected row!\n")
            print(row)
            exit(0)
    return dict


def addTopGenre(rowGenre,rowComm):
    genStr=[]
    rowGenre=rowGenre.lower()
    rowComm=rowComm.lower()
    addTG=False
    for genre in topGenres:
        orgGenre=genre
        genre=genre.lower()
        if genre in rowGenre: #genre in the name of the row's genre
            genStr.append(orgGenre)
            addTG=True
    if not addTG: #no genre found in name
        for genre in topGenres:
            addTG=False
            orgGenre=genre
            genre=genre.lower()
            if rowGenre in dictOrg: # MusicalGenre->[OrgGenres]
                for value in dictOrg[rowGenre]:
                    if genre in value : #if one of the origins has the genres name
                        genStr.append(orgGenre)
                        addTG=True
                        break
            if not addTG:
                for key in dictSub: # MusicalGenre->[SubGenres]
                    if genre in key and rowGenre in dictSub[key]: #if the genre in one of the Org, and the row in his childrens
                        genStr.append(orgGenre)
                        addTG=True
                        break
    if not addTG: #no genre found in name or origins search in comment
        for genre in topGenres:
            orgGenre=genre
            genre=genre.lower()
            if genre in rowComm:
                genStr.append(orgGenre)
                addTG=True
                break
    return genStr

def fixGenre(item):
    if item == "Tradition" or item == "Ancient" or item=='National':
        return "World"
    if item == "Lo-fi":
        return "Experimental"
    if item == "Punc":
        return "Punk"
    if item=="Garage" or item == "Thrash":
        return "Rock"
    if item == "Elctro":
        return "Electronic"
    if item == "Indo":
        return "Indie"
    return item

# find top Genres, create MusicGenreTop table and relation table
def createTopGenre():

    filepath="Data/DataTables/MusicGenreTop.csv"
    with open (filepath,'w') as f:
      f.write("name\n")
      writeGenres=[genre for genre in topGenres]
      for i in range (0,len(writeGenres)):
          writeGenres[i]=fixGenre(writeGenres[i])
      writeGenres=list(set(writeGenres))
      for genre in writeGenres:
          f.write("{0}\n".format(genre))
      f.write("Classical\n")
    f.close()

    filepath="Data/DataTables/MusicGenre.csv"
    with open(filepath) as f:
        data = list(csv.reader(f))
        f.close
    headline=data.pop(0)

    insertToDict("Data/RelationTables/MusicGenre_MusicDerivativeGenre.csv",dictDer)
    insertToDict("Data/RelationTables/MusicGenre_MusicFusionGenre.csv",dictFus)
    insertToDict("Data/RelationTables/MusicGenre_MusicStylisticOriginGenre.csv",dictOrg)
    insertToDict("Data/RelationTables/MusicGenre_MusicSubGenre.csv",dictSub)

    nameIdx=-1
    for i in range(0,len(headline)):
        if headline[i]=="name":
            nameIdx=i
        if headline[i]=="comment":
            commIdx=i
    if nameIdx<0 or commIdx<0:
        print("Error: headline not as expected!\n")
        print(headline)
        exit(0)

    filepath="Data/RelationTables/MusicGenre_MusicGenreTop.csv"
    with open(filepath,'w') as f:
        f.write("MusicGenre,TopGenre\n")
        for row in data:
            topGenreRow=addTopGenre(row[nameIdx],row[commIdx])
            if len(topGenres)==0:
                f.write("{0},World\n".format(row[nameIdx],item))
            for item in topGenreRow:
                item=fixGenre(item)
            topGenreRow=list(set(topGenreRow)) #remove doubles
            for item in topGenreRow:
                f.write("{0},{1}\n".format(row[nameIdx],item))
        f.write("Classical music composition,Classical\n")
        f.close