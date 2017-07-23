package com.example.movie_time;

import android.content.Context;
import android.graphics.Camera;
import android.graphics.Matrix;
import android.util.AttributeSet;
import android.view.View;
import android.view.animation.Transformation;
import android.widget.Gallery;
import android.widget.ImageView;

public class CoverFlow extends Gallery {

	/**
	 * Graphics Camera used for transforming the matrix of ImageViews
	 */
	private Camera mCamera = new Camera();// �����

	/**
	 * The maximum angle the Child ImageView will be rotated by
	 */
	private int mMaxRotationAngle = 80;// ���ת���Ƕ�

	/**
	 * The maximum zoom on the centre Child
	 */
	// private int mMaxZoom = -120;//�������ֵ

	/**
	 * The Centre of the Coverflow
	 */
	private int mCoveflowCenter;// �뾶ֵ

	public CoverFlow(Context context) {
		super(context);
		// ֧��ת�� ,ִ��getChildStaticTransformation����
		this.setStaticTransformationsEnabled(true);
	}

	public CoverFlow(Context context, AttributeSet attrs) {
		super(context, attrs);
		this.setStaticTransformationsEnabled(true);
	}

	public CoverFlow(Context context, AttributeSet attrs, int defStyle) {
		super(context, attrs, defStyle);
		this.setStaticTransformationsEnabled(true);
	}

	/**
	 * Get the max rotational angle of the image
	 * 
	 * @return the mMaxRotationAngle
	 */
	/** * ��ȡ��ת���Ƕ� * @return */
	public int getMaxRotationAngle() {
		return mMaxRotationAngle;
	}

	/**
	 * Set the max rotational angle of each image
	 * 
	 * @param maxRotationAngle
	 *            the mMaxRotationAngle to set
	 */
	/** * ������ת���Ƕ� * @param maxRotationAngle */
	public void setMaxRotationAngle(int maxRotationAngle) {
		mMaxRotationAngle = maxRotationAngle;
	}

	/**
	 * Get the Max zoom of the centre image
	 * 
	 * @return the mMaxZoom
	 */
	/** * ��ȡ�������ֵ * @param maxZoom */
	// public int getMaxZoom() {
	// return mMaxZoom;
	// }

	/**
	 * Set the max zoom of the centre image
	 * 
	 * @param maxZoom
	 *            the mMaxZoom to set
	 */
	/** * �����������ֵ * @param maxZoom */
	// public void setMaxZoom(int maxZoom) {
	// mMaxZoom = maxZoom;
	// }

	/**
	 * Get the Centre of the Coverflow
	 * 
	 * @return The centre of this Coverflow.
	 */
	/** * ��ȡ�뾶ֵ * @return */
	private int getCenterOfCoverflow() {
		return (getWidth() - getPaddingLeft() - getPaddingRight()) / 2
				+ getPaddingLeft();
	}

	/**
	 * Get the Centre of the View
	 * 
	 * @return The centre of the given view.
	 */
	private static int getCenterOfView(View view) {
		return view.getLeft() + view.getWidth() / 2;
	}

	/**
	 * {@inheritDoc}
	 * 
	 * @see #setStaticTransformationsEnabled(boolean)
	 */
	// ����gallery��ÿ��ͼƬ����ת(��д��gallery�з���)
	protected boolean getChildStaticTransformation(View child, Transformation t) {

		// ȡ�õ�ǰ��view�İ뾶ֵ
		final int childCenter = getCenterOfView(child);
		final int childWidth = child.getWidth();

		// ��ת�Ƕ�
		int rotationAngle = 0;
		// ����ת��״̬
		t.clear();
		// ����ת������
		t.setTransformationType(Transformation.TYPE_MATRIX);

		// ���ͼƬλ������λ�ò���Ҫ������ת
		if (childCenter == mCoveflowCenter) {
			transformImageBitmap((ImageView) child, t, 0);
		} else {
			// ����ͼƬ��gallery�е�λ��������ͼƬ����ת�Ƕ�
			rotationAngle = (int) (((float) (mCoveflowCenter - childCenter) / childWidth) * mMaxRotationAngle);
			// �����ת�ǶȾ���ֵ���������ת�Ƕȷ��أ�-mMaxRotationAngle��mMaxRotationAngle;��
			if (Math.abs(rotationAngle) > mMaxRotationAngle) {
				rotationAngle = (rotationAngle < 0) ? -mMaxRotationAngle : mMaxRotationAngle;
			}
			transformImageBitmap((ImageView) child, t, rotationAngle);
		}

		return true;
	}

	/**
	 * This is called during layout when the size of this view has changed. If
	 * you were just added to the view hierarchy, you're called with the old
	 * values of 0.
	 * 
	 * @param w
	 *            Current width of this view.
	 * @param h
	 *            Current height of this view.
	 * @param oldw
	 *            Old width of this view.
	 * @param oldh
	 *            Old height of this view.
	 */
	protected void onSizeChanged(int w, int h, int oldw, int oldh) {
		mCoveflowCenter = getCenterOfCoverflow();
		super.onSizeChanged(w, h, oldw, oldh);
	}

	/**
	 * Transform the Image Bitmap by the Angle passed
	 * 
	 * @param imageView
	 *            ImageView the ImageView whose bitmap we want to rotate
	 * @param t
	 *            transformation
	 * @param rotationAngle
	 *            the Angle by which to rotate the Bitmap
	 */
	private void transformImageBitmap(ImageView child, Transformation t,
			int rotationAngle) {
		// ��Ч�����б���
		mCamera.save();
		final Matrix imageMatrix = t.getMatrix();
		// ͼƬ�߶�
		final int imageHeight = child.getLayoutParams().height;
		// ͼƬ���
		final int imageWidth = child.getLayoutParams().width;
		// ������ת�Ƕȵľ���ֵ
		final int rotation = Math.abs(rotationAngle);

		// ��Z���������ƶ�camera���ӽǣ�ʵ��Ч��Ϊ�Ŵ�ͼƬ��
		// �����Y�����ƶ�����ͼƬ�����ƶ���X���϶�ӦͼƬ�����ƶ���
		mCamera.translate(0.0f, 0.0f, 100.0f);

		// As the angle of the view gets less, zoom in
		if (rotation < mMaxRotationAngle) {
			float zoomAmount = (float) (rotation * 1.5);
			mCamera.translate(0.0f, 0.0f, zoomAmount);
		}

		// ��Y������ת����ӦͼƬ�������﷭ת��
		// �����X������ת�����ӦͼƬ�������﷭ת��
		mCamera.rotateY(rotationAngle);
		mCamera.getMatrix(imageMatrix);
		imageMatrix.preTranslate(-(imageWidth / 2), -(imageHeight / 2));
		imageMatrix.postTranslate((imageWidth / 2), (imageHeight / 2));
		mCamera.restore();
	}
}
