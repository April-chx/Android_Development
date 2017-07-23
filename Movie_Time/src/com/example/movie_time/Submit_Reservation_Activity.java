package com.example.movie_time;

import java.util.ArrayList;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

public class Submit_Reservation_Activity extends Activity{
	
	int act_length;
	int sre_ticketprice;
	int total_ticketprice;
	int row[] = new int[4];
	int column[] = new int[4];
	String sre_showtime;
	String sre_movie;
	String sre_time;
	String sre_url;
	String sre_cinema;
	String sre_starttime;
	String sre_showtype;
	String[] sre_seat = new String[4];
	TextView[] all_seat = new TextView[4];
	
	Intent sre_intent;
	Bundle sre_bundle;
	
	@Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.submit_reservation);
        
        sre_intent = this.getIntent();
		sre_bundle = sre_intent.getExtras();
		act_length = sre_bundle.getInt("act_length");
		sre_showtime = sre_bundle.getString("showtime");
		sre_movie = sre_bundle.getString("movie");
		sre_time = sre_bundle.getString("time");
		sre_cinema = sre_bundle.getString("cinema");
		sre_starttime = sre_bundle.getString("starttime");
		sre_showtype = sre_bundle.getString("showtype");
		sre_ticketprice = sre_bundle.getInt("ticketprice");
		row = sre_bundle.getIntArray("row");
		column = sre_bundle.getIntArray("column");
		sre_seat = sre_bundle.getStringArray("seat");
		
		TextView sre_teview3 = (TextView) findViewById(R.id.textView3);
		sre_teview3.append(sre_movie);
		TextView sre_teview4 = (TextView) findViewById(R.id.textView4);
		sre_teview4.append(sre_showtype + " - " + sre_time);
		TextView sre_teview5 = (TextView) findViewById(R.id.textView5);
		sre_teview5.append(sre_showtime + "  " + sre_starttime);
		TextView sre_teview6 = (TextView) findViewById(R.id.textView6);
		sre_teview6.append(sre_cinema);
		TextView sre_teview9 = (TextView) findViewById(R.id.test);
		total_ticketprice = sre_ticketprice*act_length;
		sre_teview9.append("￥" + total_ticketprice);
		
		TextView seat1 = (TextView) findViewById(R.id.seat1);
		all_seat[0] = seat1;
		TextView seat2 = (TextView) findViewById(R.id.seat2);
		all_seat[1] = seat2;
		TextView seat3 = (TextView) findViewById(R.id.seat3);
		all_seat[2] = seat3;
		TextView seat4 = (TextView) findViewById(R.id.seat4);
		all_seat[3] = seat4;
		
		for(int i=0; i<act_length; i++)
		{
			all_seat[i].setBackgroundResource(R.drawable.txt_sharp);
			all_seat[i].append(sre_seat[i]);
		}
        
        ImageButton sre_imbutton1 = (ImageButton) findViewById(R.id.imageButton1);
		sre_imbutton1.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Submit_Reservation_Activity.this.finish();
			}
		});
		
        ImageButton sre_imbutton2 = (ImageButton) findViewById(R.id.imageButton2);
		sre_imbutton2.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(Submit_Reservation_Activity.this, Main_Interface_Activity.class);
				
				Submit_Reservation_Activity.this.startActivity(intent);
			}
		});
		
		Button sre_button1 = (Button) findViewById(R.id.button1);
		sre_button1.setOnClickListener(new Button.OnClickListener() {
			public void onClick(View v) {

				EditText nameText = (EditText) findViewById(R.id.nameText);
				EditText phoneText = (EditText) findViewById(R.id.phoneText);

				if(TextUtils.isEmpty(nameText.getText())){
					Toast.makeText(getApplicationContext(), "请输入您的姓名！", Toast.LENGTH_LONG).show();  
				}else if(TextUtils.isEmpty(phoneText.getText())){
					Toast.makeText(getApplicationContext(), "请输入您的联系电话！", Toast.LENGTH_LONG).show();  
				}else{
					String sre_row;
					String sre_column;
					String sre_ticketprice2 = "" + sre_ticketprice;
					
					for(int j=0; j<act_length; j++){
						sre_row = "" + row[j];
						sre_column = "" + column[j];
						uploadReservationInfo(nameText.getText().toString(),phoneText.getText().toString(),
							sre_movie, sre_cinema, sre_showtype, sre_showtime, sre_starttime, sre_seat[j], 
							sre_ticketprice2, sre_row, sre_column);
					}
					
					Toast.makeText(getApplicationContext(), "恭喜，预订成功！", Toast.LENGTH_LONG).show(); 
					Intent intent = new Intent();
					intent.setClass(Submit_Reservation_Activity.this, Main_Interface_Activity.class);
					
					Submit_Reservation_Activity.this.startActivity(intent);
				}		
			}
		});
	}
	
	private void uploadReservationInfo(String name, String phone, String movie, String cinema, String showtype, 
			String date, String time, String seat, String ticketprice, String row, String column){
		
        ArrayList<NameValuePair> nameValuePair = new ArrayList<NameValuePair>();  
        nameValuePair.add(new BasicNameValuePair("name", name));  
        nameValuePair.add(new BasicNameValuePair("phone", phone)); 
        nameValuePair.add(new BasicNameValuePair("movie", movie)); 
        nameValuePair.add(new BasicNameValuePair("cinema", cinema)); 
        nameValuePair.add(new BasicNameValuePair("showtype", showtype)); 
        nameValuePair.add(new BasicNameValuePair("date", date)); 
        nameValuePair.add(new BasicNameValuePair("time", time)); 
        nameValuePair.add(new BasicNameValuePair("seat", seat)); 
        nameValuePair.add(new BasicNameValuePair("ticketprice", ticketprice)); 
        nameValuePair.add(new BasicNameValuePair("row", row)); 
        nameValuePair.add(new BasicNameValuePair("column", column)); 
          
        try {  
            HttpClient httpClient = new DefaultHttpClient();  
            HttpPost httpPost = new HttpPost("http://1.movietimeapp.sinaapp.com/submit_reservation_sql.php");  
            httpPost.setEntity(new UrlEncodedFormEntity(nameValuePair, "utf-8"));   
            HttpResponse response = httpClient.execute(httpPost);  
        } catch (Exception e) { 
            Log.e("log_tag", "Error in http connection "+e.toString());  
        }   
	}
}
