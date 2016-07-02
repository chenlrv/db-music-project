
# coding: utf-8

import extractAPISparqlData
import extractAPISparqlRelation
import cleanDataAddID
import combineTwoTablesToOne
import createRelationTablesByID
import findTopGenres
import createMySQLTableFromCSV
import os
import shutil

print ("Building The DB:\n")

#create directories
print ("Creating Directories...\n")

directories=["Data","SQL_DB","Data/DataTables","Data/DataTablesClean","Data/RelationTables","Data/RelationTablesID"]
for dir in directories:
    if not os.path.exists(dir):
        os.makedirs(dir)

# Get DBPedia APIs and create CSV tables
print ("Extracting APIs Data...\n")

extractAPISparqlData.createCSVTables()
extractAPISparqlRelation.createCSVTables()


# Clean tables

print ("Cleaning Tables...\n")

cleanDataAddID.cleanFile("MusicGenre",True)
cleanDataAddID.cleanFile("MusicalArtist",True)
cleanDataAddID.cleanFile("Band",True)
cleanDataAddID.cleanFile("Album",True)
cleanDataAddID.cleanFile("ClassicalMusicComposition",True)
cleanDataAddID.cleanFile("Single",False)
cleanDataAddID.cleanFile("Song",False)

print ("Finding Top Genres...\n")
# find top genres
findTopGenres.createTopGenre()
cleanDataAddID.cleanFile("MusicGenreTop",True)

# Combine tables
print ("Combining Tables...\n")

combineTwoTablesToOne.combineTwoWithID("Data/DataTablesClean","Data/DataTablesClean","Song","Single","Songs")

combineTwoTablesToOne.combineTwo("Data/RelationTables","Data/RelationTables","Song_Artists","Single_Artists","Songs_Artists")
combineTwoTablesToOne.combineTwo("Data/RelationTables","Data/RelationTables","Song_MusicGenre","Single_MusicGenre","Songs_MusicGenre")

# Create ID relation tables
print ("Creating ID Relation Tables...\n")

createRelationTablesByID.createByID("Data/DataTablesClean","MusicalArtist","MusicGenre","Data/RelationTables","MusicalArtist_MusicGenre","Data/RelationTablesID","MusicalArtist_MusicGenre",False)
createRelationTablesByID.createByID("Data/DataTablesClean","Songs","MusicGenre","Data/RelationTables","Songs_MusicGenre","Data/RelationTablesID","Songs_MusicGenre",False)
createRelationTablesByID.createByID("Data/DataTablesClean","Album","MusicGenre","Data/RelationTables","Album_MusicGenre","Data/RelationTablesID","Album_MusicGenre",False)
createRelationTablesByID.createByID("Data/DataTablesClean","Band","MusicGenre","Data/RelationTables","Band_MusicGenre","Data/RelationTablesID","Band_MusicGenre",False)

createRelationTablesByID.createByID("Data/DataTablesClean","MusicGenre","MusicGenreTop","Data/RelationTables","MusicGenre_MusicGenreTop","Data/RelationTablesID","MusicGenre_MusicGenreTop",True)
createRelationTablesByID.createByID("Data/DataTablesClean","MusicGenre","MusicGenre","Data/RelationTables","MusicGenre_MusicDerivativeGenre","Data/RelationTablesID","MusicGenre_MusicDerivativeGenre",False)
createRelationTablesByID.createByID("Data/DataTablesClean","MusicGenre","MusicGenre","Data/RelationTables","MusicGenre_MusicFusionGenre","Data/RelationTablesID","MusicGenre_MusicFusionGenre",False)
createRelationTablesByID.createByID("Data/DataTablesClean","MusicGenre","MusicGenre","Data/RelationTables","MusicGenre_MusicStylisticOriginGenre","Data/RelationTablesID","MusicGenre_MusicStylisticOriginGenre",False)
createRelationTablesByID.createByID("Data/DataTablesClean","MusicGenre","MusicGenre","Data/RelationTables","MusicGenre_MusicSubGenre","Data/RelationTablesID","MusicGenre_MusicSubGenre",False)

createRelationTablesByID.createByID("Data/DataTablesClean","Songs","MusicalArtist","Data/RelationTables","Songs_Artists","Data/RelationTablesID","Songs_MusicalArtist",False)
createRelationTablesByID.createByID("Data/DataTablesClean","Songs","Band","Data/RelationTables","Songs_Artists","Data/RelationTablesID","Songs_Band",False)
createRelationTablesByID.createByID("Data/DataTablesClean","Album","MusicalArtist","Data/RelationTables","Album_Artists","Data/RelationTablesID","Album_MusicalArtist",False)
createRelationTablesByID.createByID("Data/DataTablesClean","Album","Band","Data/RelationTables","Album_Artists","Data/RelationTablesID","Album_Band",False)

createRelationTablesByID.createByID("Data/DataTablesClean","Band","MusicalArtist","Data/RelationTables","Band_BandMembers","Data/RelationTablesID","Band_MusicalArtist",False)

# Create SQL schema and data
print ("Creating SQL files...\n")

createMySQLTableFromCSV.createSQLTables("Data/DataTablesClean","Data/RelationTablesID")

print ("Process Successfully Finished! SQL files are in the 'SQL_DB' directory.\n")


