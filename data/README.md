Data
====

Annotations
-----------

The annotations have been generated from [MBNI](http://brainarray.mbni.med.umich.edu/Brainarray/Database/CustomCDF/18.0.0/tairg.asp) 
custom CDF files. Specifically of `aragene10st_At_TAIRG`. The description files has first been made ready for database import:

```
cat aragene10st_At_TAIRG_desc.txt | sed -e 's/_at//' -e 's/\tSymbols: /|/' -e 's/| /|/g' > cleaned
```

The data has then been imported in the database using:

```
mysql --local-infile -p -U alberto < annotation_create_import.sql
```

This creates both the table, and imports the data. The file `annotation_create_import.sql` can be found in this repository.

Data format
-----------

- Uppercase of AGi
- Remove any AGI not in main list
- ...

Cell-type specific data
-----------------------

```
mysql --local-infile -p -U alberto < ~/alberto/data/intact_create.sql
```
