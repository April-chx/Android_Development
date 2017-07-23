package com.example.movie_time;

import java.text.SimpleDateFormat;

import android.app.TabActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TabHost;
import android.widget.TextView;

public class Cinema_Introduction_Activity extends TabActivity{

	Intent ci_intent1;
	Bundle ci_bundle1;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.cinema_introduction);
		
		ci_intent1 = this.getIntent();
		ci_bundle1 = ci_intent1.getExtras();		
		String ci_cinema = ci_bundle1.getString("name");
		String ci_address = ci_bundle1.getString("address");
		String ci_phone = ci_bundle1.getString("phone");
		
		TextView ci_teview1 = (TextView)findViewById(R.id.textView1);
		ci_teview1.append(ci_cinema);
		
		TextView ci_teview2 = (TextView)findViewById(R.id.textView2);
		ci_teview2.append("地址：" + ci_address + "\n\n" + "电话：" + ci_phone);
		
		ImageButton ci_imbutton = (ImageButton) findViewById(R.id.imageButton1);
		ci_imbutton.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Cinema_Introduction_Activity.this.finish();
			}
		});
		
		ImageButton mi_imbutton2 = (ImageButton) findViewById(R.id.imageButton2);
		mi_imbutton2.setOnClickListener(new ImageButton.OnClickListener() {
			public void onClick(View v) {
				Intent intent = new Intent();
				intent.setClass(Cinema_Introduction_Activity.this, Main_Interface_Activity.class);
				
				Cinema_Introduction_Activity.this.startActivity(intent);
			}
		});
		
		SimpleDateFormat simpleDateFormat = new SimpleDateFormat("MM月dd日");    
		String date=simpleDateFormat.format(new java.util.Date());
		
		TabHost tabHost = getTabHost();
		
		Intent today_intent = new Intent();
		Intent tomorrow_intent = new Intent();
		Bundle bundle = new Bundle();	
		
		bundle.putString("cinema", ci_cinema);
		bundle.putString("address", ci_address);

		today_intent.putExtras(bundle);
		tomorrow_intent.putExtras(bundle);
		
		today_intent.setClass(this, Cinema_Introduction_TabToday.class);
		tomorrow_intent.setClass(this, Cinema_Introduction_TabTomorrow.class);
		
		tabHost.addTab(tabHost.newTabSpec("Today").setIndicator("今天(" + date + ")").setContent(today_intent));
		tabHost.addTab(tabHost.newTabSpec("Tomorrow").setIndicator("明天").setContent(tomorrow_intent));
	}
}
