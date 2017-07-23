package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;

import android.R.integer;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

public class Movie_Arrangement_Adapter extends BaseAdapter {
	
	private Context context;
	private ArrayList<HashMap<String, Object>> data;
	private String showtime;
	private String movie;
	private String time;
	private String cinema;
	/**
	 * LayoutInflater 类是代码实现中获取布局文件的主要形式 LayoutInflater layoutInflater =
	 * LayoutInflater.from(context); View convertView =
	 * layoutInflater.inflate();
	 * LayoutInflater的使用,在实际开发种LayoutInflater这个类还是非常有用的,它的作用类似于 findViewById(),
	 * 不同点是LayoutInflater是用来找layout下xml布局文件，并且实例化！ 而findViewById()是找具体xml下的具体
	 * widget控件(如:Button,TextView等)。
	 */
	private LayoutInflater layoutInflater;
	
	public Movie_Arrangement_Adapter(Context context,
			ArrayList<HashMap<String, Object>> data, String showtime, String movie, String time, String cinema) {
		
		this.context = context;
		this.data = data;
		this.showtime = showtime;
		this.movie = movie;
		this.time = time;
		this.cinema = cinema;
		this.layoutInflater = LayoutInflater.from(context);
	}

	/**
	 * 获取列数
	 */
	public int getCount() {
		return data.size();
	}

	/**
	 * 获取某一位置的数据
	 */
	public Object getItem(int position) {
		return data.get(position);
	}

	/**
	 * 获取唯一标识
	 */
	public long getItemId(int position) {
		return position;
	}

	/**
	 * android绘制每一列的时候，都会调用这个方法
	 */
	public View getView( final int position, View convertView, ViewGroup parent) {
		Movie_Arrangement_Component component = null;
		if (convertView == null) {
			component = new Movie_Arrangement_Component();
			// 获取组件布局
			convertView = layoutInflater.inflate(R.layout.movie_arrangement_item, null);
			component.starttime = (TextView) convertView.findViewById(R.id.starttime);
			component.showtype = (TextView) convertView.findViewById(R.id.showtype);
			component.ticketprice = (TextView) convertView.findViewById(R.id.ticketprice);
			component.button = (Button) convertView.findViewById(R.id.button1);
			// 这里要注意，是使用的tag来存储数据的。
			convertView.setTag(component);
		} else {
			component = (Movie_Arrangement_Component) convertView.getTag();
		}
		// 绑定数据、以及事件触发
		component.starttime.setText((String) data.get(position).get("starttime"));
		component.showtype.setText((String) data.get(position).get("showtype"));
		component.ticketprice.setText("￥"+(Integer) data.get(position).get("ticketprice"));
		
		component.button.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent ma_intent = new Intent();
				ma_intent.setClass(context, Seat_Reservation_Activity.class);
				
				Bundle ma_bundle = new Bundle();
				ma_bundle.putString("showtime", showtime);
				ma_bundle.putString("movie", movie);
				ma_bundle.putString("time", time);
				ma_bundle.putString("cinema", cinema);
				ma_bundle.putString("starttime", (String) data.get(position).get("starttime"));
				ma_bundle.putString("showtype", (String) data.get(position).get("showtype"));
				ma_bundle.putInt("ticketprice",  (Integer) data.get(position).get("ticketprice"));
				ma_intent.putExtras(ma_bundle);
				
				context.startActivity(ma_intent);
			}
		});
		return convertView;
	}

}