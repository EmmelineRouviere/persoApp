#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: FOOD
#------------------------------------------------------------

CREATE TABLE FOOD(
        foo_id        Int  Auto_increment  NOT NULL ,
        foo_name      Varchar (50) NOT NULL ,
        foo_proteines Float NOT NULL ,
        foo_lipides   Float NOT NULL ,
        foo_glucides  Float NOT NULL ,
        foo_calories  Int NOT NULL ,
        foo_weight    Float NOT NULL
	,CONSTRAINT FOOD_PK PRIMARY KEY (foo_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: NAMEMEAL
#------------------------------------------------------------

CREATE TABLE NAMEMEAL(
        nam_id          Int  Auto_increment  NOT NULL ,
        nam_label       Varchar (50) NOT NULL ,
        nam_description Varchar (50) NOT NULL
	,CONSTRAINT NAMEMEAL_PK PRIMARY KEY (nam_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: OBJECTIF
#------------------------------------------------------------

CREATE TABLE OBJECTIF(
        obj_id    Int  Auto_increment  NOT NULL ,
        obj_label Varchar (50) NOT NULL ,
        obj_state Bool NOT NULL
	,CONSTRAINT OBJECTIF_PK PRIMARY KEY (obj_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ROLE
#------------------------------------------------------------

CREATE TABLE ROLE(
        rol_id    Int  Auto_increment  NOT NULL ,
        rol_label Varchar (50) NOT NULL
	,CONSTRAINT ROLE_PK PRIMARY KEY (rol_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: USER
#------------------------------------------------------------

CREATE TABLE USER(
        use_id        Int  Auto_increment  NOT NULL ,
        use_firstname Varchar (75) NOT NULL ,
        use_lastname  Varchar (75) NOT NULL ,
        use_email     Varchar (75) NOT NULL ,
        use_birthday  Date NOT NULL ,
        use_town      Varchar (75) NOT NULL ,
        use_sexe      Bool NOT NULL ,
        rol_id        Int NOT NULL
	,CONSTRAINT USER_PK PRIMARY KEY (use_id)

	,CONSTRAINT USER_ROLE_FK FOREIGN KEY (rol_id) REFERENCES ROLE(rol_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: HEALTHDATA
#------------------------------------------------------------

CREATE TABLE HEALTHDATA(
        hea_id                     Int  Auto_increment  NOT NULL ,
        hea_actualWeight           Float NOT NULL ,
        hea_height                 Float NOT NULL ,
        hea_weightObjectif         Float NOT NULL ,
        hea_workoutObjectifPerWeek TinyINT NOT NULL ,
        use_id                     Int NOT NULL
	,CONSTRAINT HEALTHDATA_PK PRIMARY KEY (hea_id)

	,CONSTRAINT HEALTHDATA_USER_FK FOREIGN KEY (use_id) REFERENCES USER(use_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: MEAL
#------------------------------------------------------------

CREATE TABLE MEAL(
        mea_id             Int  Auto_increment  NOT NULL ,
        mea_totalCalories  Float NOT NULL ,
        mea_totalProteines Float NOT NULL ,
        mea_totalGlucides  Float NOT NULL ,
        mea_totalLipides   Float NOT NULL ,
        use_id             Int NOT NULL
	,CONSTRAINT MEAL_PK PRIMARY KEY (mea_id)

	,CONSTRAINT MEAL_USER_FK FOREIGN KEY (use_id) REFERENCES USER(use_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: TRAINING
#------------------------------------------------------------

CREATE TABLE TRAINING(
        tra_id   Int  Auto_increment  NOT NULL ,
        tra_date Date NOT NULL
	,CONSTRAINT TRAINING_PK PRIMARY KEY (tra_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: EXERCICE
#------------------------------------------------------------

CREATE TABLE EXERCICE(
        exe_id           Int  Auto_increment  NOT NULL ,
        exe_label        Varchar (5) NOT NULL ,
        exe_weight       TinyINT NOT NULL ,
        exe_nbSerie      TinyINT NOT NULL ,
        exe_nbRepetition TinyINT NOT NULL
	,CONSTRAINT EXERCICE_PK PRIMARY KEY (exe_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: addOn
#------------------------------------------------------------

CREATE TABLE addOn(
        foo_id Int NOT NULL ,
        use_id Int NOT NULL
	,CONSTRAINT addOn_PK PRIMARY KEY (foo_id,use_id)

	,CONSTRAINT addOn_FOOD_FK FOREIGN KEY (foo_id) REFERENCES FOOD(foo_id)
	,CONSTRAINT addOn_USER0_FK FOREIGN KEY (use_id) REFERENCES USER(use_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: composing
#------------------------------------------------------------

CREATE TABLE composing(
        mea_id Int NOT NULL ,
        foo_id Int NOT NULL
	,CONSTRAINT composing_PK PRIMARY KEY (mea_id,foo_id)

	,CONSTRAINT composing_MEAL_FK FOREIGN KEY (mea_id) REFERENCES MEAL(mea_id)
	,CONSTRAINT composing_FOOD0_FK FOREIGN KEY (foo_id) REFERENCES FOOD(foo_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: name
#------------------------------------------------------------

CREATE TABLE name(
        nam_id Int NOT NULL ,
        mea_id Int NOT NULL
	,CONSTRAINT name_PK PRIMARY KEY (nam_id,mea_id)

	,CONSTRAINT name_NAMEMEAL_FK FOREIGN KEY (nam_id) REFERENCES NAMEMEAL(nam_id)
	,CONSTRAINT name_MEAL0_FK FOREIGN KEY (mea_id) REFERENCES MEAL(mea_id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: constitute
#------------------------------------------------------------

CREATE TABLE constitute(
        tra_id Int NOT NULL ,
        use_id Int NOT NULL
	,CONSTRAINT constitute_PK PRIMARY KEY (tra_id,use_id)

	,CONSTRAINT constitute_TRAINING_FK FOREIGN KEY (tra_id) REFERENCES TRAINING(tra_id)
	,CONSTRAINT constitute_USER0_FK FOREIGN KEY (use_id) REFERENCES USER(use_id)
)ENGINE=InnoDB;


#------------------------------------------------------------




	=======================================================================
	   Désolé, il faut activer cette version pour voir la suite du script ! 
	=======================================================================
