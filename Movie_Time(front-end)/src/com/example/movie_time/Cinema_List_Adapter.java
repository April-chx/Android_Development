package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;

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

public class Cinema_List_Adapter extends BaseAdapter {
	
	private Context context;
	private ArrayList<HashMap<String, Object>> data;
	private String movie;
	private String time;
	private String movietype;
	private String url;
	/**
	 * LayoutInflater 类是代码实现中获取布局文件的主要形式 LayoutInflater layoutInflater =
	 * LayoutInflater.from(context); View convertView =
	 * layoutInflater.inflate();
	 * LayoutInflater的使用,在实际开发种LayoutInflater这个类还是非常有用的,它的作用类似于 findViewById(),
	 * 不同点是LayoutInflater是用来找layout下xml布局文件，并且实例化！ 而findViewById()是找具体xml下的具体
	 * widget控件(如:Button,TextView等)。
	 */
	private LayoutInflater layoutInflater;
	
	public Cinema_List_Adapter(Context context, ArrayList<HashMap<String, Object>> data, String movie, String time, String movietype, String url) {

		this.context = context;
		this.data = data;
		this.movie = movie;
		this.time = time;
		this.movietype = movietype;
		this.url = url;
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
	public View getView(final int position, View convertView, ViewGroup parent) {
		Cinema_List_Component component = null;
		if (convertView == null) {
			component = new Cinema_List_Component();
			// 获取组件布局
			convertView = layoutInflater.inflate(R.layout.cinema_list_item, null);
			component.cinemaView = (TextView) convertView.findViewById(R.id.cinema);
			component.addressView = (TextView) convertView.findViewById(R.id.address);
			component.button = (Button) convertView.findViewById(R.id.button1);
			// 这里要注意，是使用的tag来存储数据的。
			convertView.setTag(component);
		} else {
			component = (Cinema_List_Component) convertView.getTag();
		}
		// 绑定数据、以及事件触发
		component.cinemaView.setText((String) data.get(position).get("cinema"));
		component.addressView.setText((String) data.get(position).get("address"));
		
		component.button.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent ci_intent = new Intent();
				ci_intent.setClass(context, Movie_Arrangement_Activity.class);
				
				Bundle ci_bundle = new Bundle();				
				ci_bundle.putString("movie", movie);
				ci_bundle.putString("time", time);
				ci_bundle.putString("movietype", movietype);
				ci_bundle.putString("url", url);
				ci_bundle.putString("cinema", (String)data.get(position).get("cinema"));
				ci_bundle.putString("address", (String)data.get(position).get("address"));
				ci_intent.putExtras(ci_bundle);
				
				context.startActivity(ci_intent);
			}

		});
		return convertView;
	}

	/**
	 * 当用户点击按钮时触发的事件，会弹出一个确认对话框
	 */
//	public void showInfo() {
//
//		new AlertDialog.Builder(context)
//
//		.setTitle("我的listview")
//
//		.setMessage("介绍...")
//
//		.setPositiveButton("确定", new DialogInterface.OnClickListener() {
//
//			public void onClick(DialogInterface dialog, int which) {
//
//			}
//
//		})
//
//		.show();
//
//	}

}