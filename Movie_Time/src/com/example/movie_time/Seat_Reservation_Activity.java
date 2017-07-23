package com.example.movie_time;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

public class Seat_Reservation_Activity extends Activity{
	
	int x;
	int y;
	int count = 0;
	int num = 0;
	int act_length = 0;
	int sr_ticketprice;
	int row[] = new int[4];
	int column[] = new int[4];
	String sr_showtime;
	String sr_movie;
	String sr_time;
	String sr_cinema;
	String sr_starttime;
	String sr_showtype;
	String is_clicked[] = {"0","0","0","0"};
	CheckBox all_checkbox[][] = new CheckBox[6][8];
	
	Intent sr_intent1;
	Bundle sr_bundle1;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.seat_reservation);
        
        sr_intent1 = this.getIntent();
		sr_bundle1 = sr_intent1.getExtras();	
		sr_showtime = sr_bundle1.getString("showtime");
		sr_movie = sr_bundle1.getString("movie");
		sr_time = sr_bundle1.getString("time");
		sr_cinema = sr_bundle1.getString("cinema");
		sr_starttime = sr_bundle1.getString("starttime");
		sr_showtype = sr_bundle1.getString("showtype");
		sr_ticketprice = sr_bundle1.getInt("ticketprice");
		
		TextView sr_teview1 = (TextView) findViewById(R.id.textView1);
		sr_teview1.append(sr_movie);
		TextView sr_teview2 = (TextView) findViewById(R.id.textView2);
		sr_teview2.append(sr_showtype + " " + sr_time);
		TextView sr_teview3 = (TextView) findViewById(R.id.textView3);
		sr_teview3.append(sr_showtime + " - " + sr_starttime);
		TextView sr_teview4 = (TextView) findViewById(R.id.textView4);
		sr_teview4.append(sr_cinema);
		TextView sr_teview8 = (TextView) findViewById(R.id.textView8);
		sr_teview8.append("￥" + sr_ticketprice + "/张");
		
		CheckBox check11 = (CheckBox)findViewById(R.id.checkBox11);  
		all_checkbox[0][0] = check11;
	    CheckBox check12 = (CheckBox)findViewById(R.id.checkBox12);
	    all_checkbox[0][1] = check12;
	    CheckBox check13 = (CheckBox)findViewById(R.id.checkBox13); 
	    all_checkbox[0][2] = check13;
	    CheckBox check14 = (CheckBox)findViewById(R.id.checkBox14);
	    all_checkbox[0][3] = check14;
	    CheckBox check15 = (CheckBox)findViewById(R.id.checkBox15); 
	    all_checkbox[0][4] = check15;
	    CheckBox check16 = (CheckBox)findViewById(R.id.checkBox16);
	    all_checkbox[0][5] = check16;
	    CheckBox check17 = (CheckBox)findViewById(R.id.checkBox17);
	    all_checkbox[0][6] = check17;
	    CheckBox check18 = (CheckBox)findViewById(R.id.checkBox18);
	    all_checkbox[0][7] = check18;
	    CheckBox check21 = (CheckBox)findViewById(R.id.CheckBox21);
	    all_checkbox[1][0] = check21;
	    CheckBox check22 = (CheckBox)findViewById(R.id.CheckBox22);
	    all_checkbox[1][1] = check22;
	    CheckBox check23 = (CheckBox)findViewById(R.id.CheckBox23);  
	    all_checkbox[1][2] = check23;
	    CheckBox check24 = (CheckBox)findViewById(R.id.CheckBox24);
	    all_checkbox[1][3] = check24;
	    CheckBox check25 = (CheckBox)findViewById(R.id.CheckBox25);  
	    all_checkbox[1][4] = check25;
	    CheckBox check26 = (CheckBox)findViewById(R.id.CheckBox26);
	    all_checkbox[1][5] = check26;
	    CheckBox check27 = (CheckBox)findViewById(R.id.CheckBox27); 
	    all_checkbox[1][6] = check27;
	    CheckBox check28 = (CheckBox)findViewById(R.id.CheckBox28);
	    all_checkbox[1][7] = check28;
	    CheckBox check31 = (CheckBox)findViewById(R.id.CheckBox31);  
	    all_checkbox[2][0] = check31;
	    CheckBox check32 = (CheckBox)findViewById(R.id.CheckBox32);
	    all_checkbox[2][1] = check32;
	    CheckBox check33 = (CheckBox)findViewById(R.id.CheckBox33); 
	    all_checkbox[2][2] = check33;
	    CheckBox check34 = (CheckBox)findViewById(R.id.CheckBox34);
	    all_checkbox[2][3] = check34;
	    CheckBox check35 = (CheckBox)findViewById(R.id.CheckBox35); 
	    all_checkbox[2][4] = check35;
	    CheckBox check36 = (CheckBox)findViewById(R.id.CheckBox36);
	    all_checkbox[2][5] = check36;
	    CheckBox check37 = (CheckBox)findViewById(R.id.CheckBox37);  
	    all_checkbox[2][6] = check37;
	    CheckBox check38 = (CheckBox)findViewById(R.id.CheckBox38);
	    all_checkbox[2][7] = check38;
	    CheckBox check41 = (CheckBox)findViewById(R.id.CheckBox41);  
	    all_checkbox[3][0] = check41;
	    CheckBox check42 = (CheckBox)findViewById(R.id.CheckBox42);
	    all_checkbox[3][1] = check42;
	    CheckBox check43 = (CheckBox)findViewById(R.id.CheckBox43);  
	    all_checkbox[3][2] = check43;
	    CheckBox check44 = (CheckBox)findViewById(R.id.CheckBox44);
	    all_checkbox[3][3] = check44;
	    CheckBox check45 = (CheckBox)findViewById(R.id.CheckBox45);
	    all_checkbox[3][4] = check45;
	    CheckBox check46 = (CheckBox)findViewById(R.id.CheckBox46);
	    all_checkbox[3][5] = check46;
	    CheckBox check47 = (CheckBox)findViewById(R.id.CheckBox47);  
	    all_checkbox[3][6] = check47;
	    CheckBox check48 = (CheckBox)findViewById(R.id.CheckBox48);
	    all_checkbox[3][7] = check48;
	    CheckBox check51 = (CheckBox)findViewById(R.id.CheckBox51); 
	    all_checkbox[4][0] = check51;
	    CheckBox check52 = (CheckBox)findViewById(R.id.CheckBox52);
	    all_checkbox[4][1] = check52;
	    CheckBox check53 = (CheckBox)findViewById(R.id.CheckBox53);  
	    all_checkbox[4][2] = check53;
	    CheckBox check54 = (CheckBox)findViewById(R.id.CheckBox54);
	    all_checkbox[4][3] = check54;
	    CheckBox check55 = (CheckBox)findViewById(R.id.CheckBox55);  
	    all_checkbox[4][4] = check55;
	    CheckBox check56 = (CheckBox)findViewById(R.id.CheckBox56);
	    all_checkbox[4][5] = check56;
	    CheckBox check57 = (CheckBox)findViewById(R.id.CheckBox57);  
	    all_checkbox[4][6] = check57;
	    CheckBox check58 = (CheckBox)findViewById(R.id.CheckBox58);
	    all_checkbox[4][7] = check58;
	    CheckBox check61 = (CheckBox)findViewById(R.id.CheckBox61);  
	    all_checkbox[5][0] = check61;
	    CheckBox check62 = (CheckBox)findViewById(R.id.CheckBox62);
	    all_checkbox[5][1] = check62;
	    CheckBox check63 = (CheckBox)findViewById(R.id.CheckBox63);  
	    all_checkbox[5][2] = check63;
	    CheckBox check64 = (CheckBox)findViewById(R.id.CheckBox64);
	    all_checkbox[5][3] = check64;
	    CheckBox check65 = (CheckBox)findViewById(R.id.CheckBox65);  
	    all_checkbox[5][4] = check65;
	    CheckBox check66 = (CheckBox)findViewById(R.id.CheckBox66);
	    all_checkbox[5][5] = check66;
	    CheckBox check67 = (CheckBox)findViewById(R.id.CheckBox67);  
	    all_checkbox[5][6] = check67;
	    CheckBox check68 = (CheckBox)findViewById(R.id.CheckBox68);
	    all_checkbox[5][7] = check68; 
		
	    for(int i=0; i<6; i++){
			for(int j=0; j<8; j++){
				all_checkbox[i][j].setOnCheckedChangeListener(listener);	
			}
		}
	    
        try{
        	JSONArray jArray = new JSONArray(seatIsClicked(sr_movie, sr_cinema, sr_showtime, sr_starttime));  
        	if (jArray.length() > 0) {  
        		for (int i = 0; i < jArray.length(); i++) {  
        			JSONObject json_data = jArray.getJSONObject(i);   
        			all_checkbox[json_data.getInt("排")][json_data.getInt("列")].setBackgroundResource(R.drawable.checkbox_background);
        			all_checkbox[json_data.getInt("排")][json_data.getInt("列")].setClickable(false);
        		}  
        	} 
        } catch (Exception e) {   
        	Log.e("log_tag", "Error parsing data "+e.toString());  
        }  

        ImageButton sr_imbutton1 = (ImageButton) findViewById(R.id.imageButton1);
		sr_imbutton1.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Seat_Reservation_Activity.this.finish();
			}
		});
		
        ImageButton sr_imbutton2 = (ImageButton) findViewById(R.id.imageButton2);
		sr_imbutton2.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(Seat_Reservation_Activity.this, Main_Interface_Activity.class);
				
				Seat_Reservation_Activity.this.startActivity(intent);
			}
		});
		
		Button sr_button1 = (Button) findViewById(R.id.button1);
		sr_button1.setOnClickListener(new Button.OnClickListener() {
			public void onClick(View v) {
				
				for(int i=0; i<6; i++){
					for(int j=0; j<8; j++){
						if(all_checkbox[i][j].isChecked()){
							x = i + 1;
							y = j + 1;
							row[num] = i;
							column[num] = j;
							is_clicked[num] = x + "排" + y + "座";
							num++;
						}		
					}
				}
				
				for(int k=0; k<4; k++){
					if(is_clicked[k] != "0"){
						act_length++;
					}
				}

				if(act_length == 0){
					Toast.makeText(getApplicationContext(), "请先选择您想要的座位！", Toast.LENGTH_LONG).show();  
				}else{
					Intent sr_intent2 = new Intent();
					sr_intent2.setClass(Seat_Reservation_Activity.this, Submit_Reservation_Activity.class);

					Bundle sr_bundle2 = new Bundle();
					sr_bundle2.putInt("act_length", act_length);
					sr_bundle2.putString("showtime", sr_showtime);
					sr_bundle2.putString("movie", sr_movie);
					sr_bundle2.putString("time", sr_time);
					sr_bundle2.putString("cinema", sr_cinema);
					sr_bundle2.putString("starttime", sr_starttime);
					sr_bundle2.putString("showtype", sr_showtype);
					sr_bundle2.putInt("ticketprice", sr_ticketprice);
					sr_bundle2.putIntArray("row", row);
					sr_bundle2.putIntArray("column", column);
					sr_bundle2.putStringArray("seat", is_clicked);
					sr_intent2.putExtras(sr_bundle2);
				
					Seat_Reservation_Activity.this.startActivity(sr_intent2);
				}
			}
		});
	}

	private OnCheckedChangeListener listener = new OnCheckedChangeListener(){
		@Override  
		public void onCheckedChanged(CompoundButton buttonView,boolean isChecked){  
			if(buttonView.isChecked()){
				count++;
			}else{
				count--;
			}
			
			if(count<=4){
				count = count < 0 ? 0 : count;
			}else {
				count = count > 4 ? 4 : count;
				buttonView.setChecked(false);			
			}
		}
    };
    
    private String seatIsClicked(String movie, String cinema, String date, String starttime)  
    {  
        InputStream is = null;  
        String result = "";   
        starttime = starttime + ":00";
        
        ArrayList<NameValuePair> nameValuePair = new ArrayList<NameValuePair>();  
        nameValuePair.add(new BasicNameValuePair("movie", movie));  
        nameValuePair.add(new BasicNameValuePair("cinema", cinema));
        nameValuePair.add(new BasicNameValuePair("date", date));
        nameValuePair.add(new BasicNameValuePair("starttime", starttime));
          
        try {   
            HttpClient httpClient = new DefaultHttpClient(); 
            HttpPost httpPost = new HttpPost("http://1.movietimeapp.sinaapp.com/seat_reservation_sql.php"); 
            httpPost.setEntity(new UrlEncodedFormEntity(nameValuePair, "utf-8"));   
            HttpResponse response = httpClient.execute(httpPost);  
            HttpEntity entity = response.getEntity();  
            is = entity.getContent();  
        } catch (Exception e) {  
            Log.e("log_tag", "Error in http connection "+e.toString());  
        }   

        try {  
            BufferedReader br = new BufferedReader(new InputStreamReader(is, "iso-8859-1"), 8);  
            StringBuilder sb = new StringBuilder();  
            String line = null;  
            while ((line = br.readLine()) != null) {  
                sb.append(line + "\n");  
            }  
            is.close(); 
            result = sb.toString();  
        } catch (Exception e) {  
            Log.e("log_tag", "Error converting result "+e.toString());  
        }  
        return result;
    }
}
