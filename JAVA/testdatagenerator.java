import java.sql.*;
import oracle.jdbc.driver.*;

public class testdatagenerator {
  static Statement stmt;

  public static void main(String args[]) {


try {
		stmt = connection.createStatement();

		System.out.println("Hotels connected!");
    } catch (Exception e) {
      System.err.println(e.getMessage());
    }


/*
    try {
    
      Class.forName("oracle.jdbc.driver.OracleDriver");
      String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
      String user = "a01469313";
      String pass = "atmospero1";

      // establish connection to database 
      Connection con = DriverManager.getConnection(database, user, pass);
      Statement stmt = con.createStatement();

*/
/*
    } catch (Exception e) {
      System.err.println(e.getMessage());
    }*/




// insert Arzt
	  String[] nachname = {"Kul", "Mueller", "Wanek", "Khachidze", "Varabye", "Polaschek", "Ronaldo", "Messi", "Yarmolenko", "Finkel"};
	  String[] vorname = {"Hakan", "Matias", "Helmut", "Tornike", "Ivan", "Martin", "Cristiano", "Leonel", "Andrey", "Dina"};
	  
      for (int i = 0; i < 100; i++) {
        String insertSql = "INSERT INTO Arzt (ANACHNAME, AVORNAME) VALUES ('" + nachname[ (int) (Math.random() * 10) ] + "', '" + vorname[ (int) (Math.random() * 10) ] + "')";
		//System.out.println(insertSql);

		try {
        stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
      }

      }

     

     // insert Patient
	  String[] pnachname = {"Janker", "Robben", "Snejder", "Pirlo", "Nesta", "Maldini", "Totti", "Inzaghi", "Vieri", "Bagio"};
	  String[] pvorname = {"Karsten", "Arien", "Wesly", "Andrea", "Alexsandro", "Paolo", "Francesco", "Filipo", "Cristian", "Roberto"};
	  String[] port = {"Milan", "Rom", "Wien", "Baden", "Linz", "Graz", "London", "Manchester", "Liverpol", "Birmingem"};
	  String[] pstrasse = {"Nullgasse", "Hochstrasse", "Hpstrasse", "Badenerstrasse", "Lkvgasse", "nordgasse", "ostgasse", "westgasse", "messigasse", "tottistrasse"};
      String[] month= {"Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"};
	  String[] diagnosse = {"abbaba", "zrzrzttt", "qeqeqwes", "ttrwrewr", "nnnm", "vvccc", "uiiiiiu", "oooooop", "lkkrey", "oioiuz"};
	  
	  
	  
      for (int i = 0; i < 100; i++) {
                   String monat= (month[(int)((Math.random() * 11)+0)]);
		   int tag;
		
			if(monat == "Feb"){
				monat="Feb";
				tag=((int)((Math.random() * 28)+1));
			}
			else if(monat == "Apr" ) {
				monat="Apr";
				tag=((int)((Math.random() * 30)+1));
			}
			else if(monat == "June" ) {
				monat="June";
				tag=((int)((Math.random() * 30)+1));
			}
			else if(monat == "Sep") {
				monat="Sep";
				tag=((int)((Math.random() * 30)+1));
			}
			else if(monat == "Nov") {
				monat="Nov";
				tag=((int)((Math.random() * 30)+1));
			}
			else{
				tag=((int)((Math.random() * 31)+1));
			}

                    String monat2= (month[(int)((Math.random() * 11)+0)]);
		   int tag2;
		
			if(monat2 == "Feb"){
				monat2="Feb";
				tag2=((int)((Math.random() * 28)+1));
			}
			else if(monat2 == "Apr" ) {
				monat2="Apr";
				tag2=((int)((Math.random() * 30)+1));
			}
			else if(monat2 == "June" ) {
				monat2="June";
				tag2=((int)((Math.random() * 30)+1));
			}
			else if(monat2 == "Sep") {
				monat2="Sep";
				tag2=((int)((Math.random() * 30)+1));
			}
			else if(monat2 == "Nov") {
				monat2="Nov";
				tag2=((int)((Math.random() * 30)+1));
			}
			else{
				tag2=((int)((Math.random() * 31)+1));
			}


        String insertSql = "INSERT INTO Patient VALUES ('', '" 
		+ pnachname[ (int) (Math.random() * 10) ] + "', '" 
		+ pvorname[ (int) (Math.random() * 10) ] + "', '"
		+ (1000 + (int) (Math.random() * 9000)) + "', '"
		+ port[ (int) (Math.random() * 10) ] + "', '" 
		+ pstrasse[ (int) (Math.random() * 10) ] + "','"
                + tag +'-' + monat +'-' +(int)((Math.random() * 61)+1940) + "','"
                + (1+(int) (Math.random() * 99)) +"', '"
		+ diagnosse[ (int) (Math.random() * 10) ] + "','"
                + tag2 +'-' + monat2 +'-' +(int)((Math.random() * 2)+2015) +"')";
		//System.out.println(insertSql);

		try {
        stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
      }

	  }
	  
	    // insert Rechnung
                   String[] verart = {"GKV", "Privat"};


	        for (int i = 0; i < 100; i++) {

                   String monat3= (month[(int)((Math.random() * 11)+0)]);
		   int tag3;
		
			if(monat3 == "Feb"){
				monat3="Feb";
				tag3=((int)((Math.random() * 28)+1));
			}
			else if(monat3 == "Apr" ) {
				monat3="Apr";
				tag3=((int)((Math.random() * 30)+1));
			}
			else if(monat3 == "June" ) {
				monat3="June";
				tag3=((int)((Math.random() * 30)+1));
			}
			else if(monat3 == "Sep") {
				monat3="Sep";
				tag3=((int)((Math.random() * 30)+1));
			}
			else if(monat3 == "Nov") {
				monat3="Nov";
				tag3=((int)((Math.random() * 30)+1));
			}
			else{
				tag3=((int)((Math.random() * 31)+1));
			}

        String insertSql = "INSERT INTO Rechnung VALUES ('','" 
                            + tag3 +'-' + monat3 +'-' +(int)((Math.random() * 2)+2015) + "','" 
                            + (int) ((Math.random() * 471) + 30) + "','" 
                            + (int) ((Math.random() * 100) +1)  + "','"
                            + verart[ (int) (Math.random() * 2) ] + "')";
		//System.out.println(insertSql);

		try {
        stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
      }

	  }
	  

// insert Praxisgemeinschaft

	  String[] pgname = {"WIENTHERAPIE", "BADEN", "MASSAGE"};
	 
	  
      for (int i = 0; i < 3; i++) {
        String insertSql = "INSERT INTO Praxisgemeinschaft (PGID, PGNAME) VALUES ('', '" + pgname[ (int) (Math.random() * 3) ] + "')";
		//System.out.println(insertSql);

		try {
        stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
      }

      }


// insert Heilmasseur
	  String[] hnachname = {"Koller", "Janker", "Samoilenko", "Schevchenko", "Varabye", "Rebrov", "Kalashnikov", "Knapp", "Yarmolenko", "Sidorov"};
	  String[] hvorname = {"Filipo", "Tony", "Tomy", "Gerhard", "Sergey", "Hakan", "Tomas", "Kristian", "Andy", "Roberto"};
	  String[] tn = {"0650", "0676", "0664", "0699", "0660"};


      for (int i = 0; i < 10; i++) {
        String insertSql = "INSERT INTO Heilmasseur VALUES ('', '" 
                            + hnachname[ (int) (Math.random() * 10) ] + "', '"
                            + hvorname[ (int) (Math.random() * 10) ] + "','"
                            + (int) ((Math.random() * 71)+18) + "','"
                            + tn[ (int) (Math.random() * 5) ] + '/' +(int) ((Math.random() *9000000) +1) + "','"
                            + (int) ((Math.random() * 1)+1) + "')";
                             //System.out.println(insertSql);

	try {
        stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
      }

      }




      // check number of datasets in Arzt table
      ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Arzt");
      if (rs.next()) {
        int count = rs.getInt(1);
        System.out.println("Number of arzt: " + count);
      }

      // check number of datasets in Patient table
      ResultSet rs1 = stmt.executeQuery("SELECT COUNT(*) FROM Patient");
      if (rs1.next()) {
        int count = rs1.getInt(1);
        System.out.println("Number of patient: " + count);
      }

      // check number of datasets in Rechnung table
      ResultSet rs2 = stmt.executeQuery("SELECT COUNT(*) FROM Rechnung");
      if (rs2.next()) {
        int count = rs2.getInt(1);
        System.out.println("Number of rechnung: " + count);
      }


      // check number of datasets in Praxisgemeinschaft table
      ResultSet rs3 = stmt.executeQuery("SELECT COUNT(*) FROM Praxisgemeinschaft");
      if (rs3.next()) {
        int count = rs3.getInt(1);
        System.out.println("Number of praxisgemeinschaft: " + count);
      }

 // check number of datasets in Heilmasseur table
      ResultSet rs4 = stmt.executeQuery("SELECT COUNT(*) FROM Heilmasseur");
      if (rs4.next()) {
        int count = rs4.getInt(1);
        System.out.println("Number of Heilmasseur: " + count);
      }




      // clean up connections
      rs.close();
      stmt.close();
      con.close();

    } catch (Exception e) {
      System.err.println(e.getMessage());
    }
  }
}