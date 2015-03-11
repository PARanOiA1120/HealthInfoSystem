#Partner: Dalin Wang
create database HealthInformationSystem;
use HealthInformationSystem;

#2.2 Guardians
#Each patient has exactly one guardian. the relation is specified by
#the patientrole attribute of Patient.
create table `Guardians`(
	`GuardianNo` varchar(100),
	`FirstName` varchar(100) DEFAULT NULL,
	`LastName` varchar(100) DEFAULT NULL,
	`phone` varchar(100) DEFAULT NULL,
	`address` varchar(100) DEFAULT NULL,
	`city` varchar(100) DEFAULT NULL,
	`state` varchar(100) DEFAULT NULL,
	`zip` varchar(100) DEFAULT NULL,
	primary key(`GuardianNo`)
);

#2.4 Insurance Company
#Each patient has exactly one insurance.
create table `InsuranceCompany`(
   `PayerId` varchar(100),
   `Name` varchar(100) DEFAULT NULL,
    primary key(`PayerId`)
);

#2.1 Patient
create table `Patient`(
	`patientId` varchar(100),
	`GivenName` varchar(100) DEFAULT NULL,
	`FamilyName` varchar(100) DEFAULT NULL,
	`BirthTime` varchar(100) DEFAULT NULL,
	`suffix` varchar(100) DEFAULT NULL,
    `gender` varchar(100) DEFAULT NULL,
    #Guardian info
	`GuardianNo` varchar(100) NOT NULL,
    `Relationship` varchar(100) DEFAULT NULL,
    #InsuranceCompany
    `providerId` varchar(100) NOT NULL,
    `PayerId` varchar(100) NOT NULL,
    `PolicyType` varchar(100) DEFAULT NULL,
	`Purpose` varchar(100) DEFAULT NULL,
    `PolicyHolder` varchar(100) DEFAULT NULL,
    `xmlCreationDate` varchar(100), 

    primary key(`patientId`),
    foreign key(`guardianNO`) references `Guardians`(`guardianNO`),
    foreign key(`PayerId`) references `InsuranceCompany`(`PayerId`)
);

#2.3 Author
#Each patient can be ASSIGNED many authors. 
#Some patients do not have any authors
create table `Author`(
	`AuthorId` varchar(100),
	`AuthorTitle` varchar(100) DEFAULT NULL,
	`AuthorFirstName` varchar(100) DEFAULT NULL,
	`AuthorLastName` varchar(100) DEFAULT NULL,
    primary key(`AuthorId`)
);

create table `Author_Records_Patient`(
    `AuthorId` varchar(100),
	`patientId` varchar(100),
	`ParticipatingRole` varchar(100) DEFAULT NULL,
    primary key(`patientId`, `AuthorId`),
    foreign key(`patientId`) references `Patient`(`patientId`)
    ON DELETE CASCADE,
    foreign key(`AuthorId`) references `Author`(`AuthorId`)
    ON DELETE CASCADE
);

#2.6 Allergies
create table `Allergies`(
    `Allergy_id` varchar(100),
	`Substance` varchar(100) DEFAULT NULL,
	primary key(`Allergy_id`)
);


create table `Patient_has_Allergies`(
  	`patientId` varchar(100),
  	`Allergy_id` varchar(100),
	`Reaction` varchar(100) DEFAULT NULL,
    `Status` varchar(100) DEFAULT NULL,
	primary key(`patientId`, `Allergy_id`),
	foreign key(`patientId`) references `Patient`(`patientId`)  
	ON DELETE CASCADE,
	foreign key(`Allergy_id` ) references `Allergies`(`Allergy_id`)
    ON DELETE CASCADE
);


#2.7 LabTestReport
create table `LabTestReport`(
	`patientId` varchar(100),
	`LabTestResultId` varchar(100),
	`PatientVisitId` varchar(100),
    `LabTestType` varchar(100),
    `TestResultValue` float,
	`ReferenceRangeHigh` float,
    `ReferenceRangeLow` float,
	`LabTestPerformedDate` varchar(100),
	primary key(`patientId`,`LabTestResultId`, `LabTestType`, `PatientVisitId`),
    foreign key(`patientId`) references `Patient`(`patientId`) ON DELETE CASCADE
);


#2.8 Plan
create table `Activity`(
	`Activity` varchar(100),
    primary key(`Activity`)
);

create table `patient_plans_activity`(
	`patientId` varchar(100),
    `PlanId` varchar(100),
    `Activity` varchar(100),
	`ScheduledDate` varchar(100) DEFAULT NULL,
    
	primary key(`patientId`, `PlanId`),
	foreign key(`patientId`) references `Patient`(`patientId`)
	ON DELETE CASCADE,
    foreign key(`Activity`) references `Activity`(`Activity`)
);


#2.5 FamilyHistory
#Family history is optional for patient, we could record 
#the history of several family members of a patient.
create table `relatives`(
	`RelativeId` varchar(100),
	`age` integer DEFAULT NULL,
	`Diagnosis` varchar(100),
	primary key(`RelativeId`)
);


create table `Patient_has_FamilyHistory`(
	`patientId` varchar(100),
    `RelativeId` varchar(100),
    `Relation` varchar(100) DEFAULT NULL,
	primary key(`patientId`, `RelativeId`),
    foreign key(`RelativeId`) references `relatives`(`RelativeId`),
	foreign key(`patientId`) references `Patient`(`patientId`)
    ON DELETE CASCADE
);







